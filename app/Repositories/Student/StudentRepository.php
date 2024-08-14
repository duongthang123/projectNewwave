<?php

namespace App\Repositories\Student;

use App\Helpers\UploadHelper;
use App\Jobs\SendAccountStudentMail;
use App\Models\Student;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StudentRepository extends BaseRepository
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
    }

    public function getModel()
    {
        return Student::class;
    }

    public function fillter($request)
    {
        $students = $this->model::select('id', 'user_id', 'student_code', 'status', 'gender', 'birthday')
                                ->with('user:id,name,email', 'subjects:id');
                                
        if(isset($request['age_from'])) {
            $ageFromDate = Carbon::now()->subYears($request['age_from'])->startOfDay()->format('Y-m-d');
            $students->where('birthday', '<=', $ageFromDate);
        }

        if(isset($request['age_to'])) {
            $ageToDate = Carbon::now()->subYears($request['age_to'])->endOfDay()->format('Y-m-d');
            $students->where('birthday', '>=', $ageToDate);
        }

        if (isset($request['score_from']) || isset($request['score_to'])) {
            $students->whereHas('subjects', function ($query) use ($request) {
                $query->select('student_subject.student_id', DB::raw('AVG(student_subject.score) as avg_score'))
                      ->groupBy('student_subject.student_id');
    
                if (isset($request['score_from'])) {
                    $query->havingRaw('AVG(student_subject.score) >= ?', [$request['score_from']]);
                }
                if (isset($request['score_to'])) {
                    $query->havingRaw('AVG(student_subject.score) <= ?', [$request['score_to']]);
                }
            });
        }

        if (isset($request['phone_type'])) {
            switch($request['phone_type']) {
                case config('const.PHONE_NUMBER_TYPE.VIETTEL'):
                    $students->where('phone', 'regexp', '^(098|097|096)');
                    break;
                case config('const.PHONE_NUMBER_TYPE.MOBILEFONE'):
                    $students->where('phone', 'regexp', '^(091|094)');
                    break;
                case config('const.PHONE_NUMBER_TYPE.VINAPHONE'):
                    $students->where('phone', 'regexp', '^(090|093)');
                    break;
                default: break;
            }
        }

        if(isset($request['status'])) {
            $students->where('status', $request['status']);
        }

        $perPage = isset($request['per_page']) ? $request['per_page'] : config('const.PER_PAGE.10');

        return $students->latest('id')->paginate($perPage);
    }

    public function getStudentByIdWithUser($id)
    {
        return $this->model::with('user')->findOrFail($id);
    }

    public function createStudent($request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();

            $user = $this->userRepo->create($data);
            $user->assignRole('student');
            $data['user_id'] = $user->id;
            $data['student_code'] = date('Y') . $user->id;
            $data['avatar'] = $request->file('avatar') ? $request->file('avatar')->getClientOriginalName() : '';
            
            $this->create($data);
            if($request->hasFile('avatar')){
                UploadHelper::uploadFile($request);
            }
            SendAccountStudentMail::dispatch($data);
            DB::commit();

            toastr()->success('Create student successfully!');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Create student failed!');
            return false;
        }
    }

    public function updateStudent($request, $id)
    {
        $data = $request->except('password', 'email');

        try {
            DB::beginTransaction();
            $student = $this->find($id);
            if($student) {
                $data['user_id'] = $student->user_id;
                $data['student_code'] = $student->student_code;
                $data['avatar'] = $request->file('avatar') ? $request->file('avatar')->getClientOriginalName() : $student->avatar;
                
                $this->update($data, $id);
                $userData = [
                    'name' => $data['name'],
                    'email' => $student->user->email
                ];
                if($request->password) {
                    $userData['password'] = $request->password;
                }
        
                if($request->hasFile('avatar')){
                    UploadHelper::uploadFile($request);
                }
        
                $this->userRepo->update($userData, $data['user_id']);
            }
            DB::commit();
            return true;
        }catch(\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function deleteStudent($id)
    {
        $student = $this->find($id);
        if ($student) {
            $student->user->delete();
            return $student->delete();
        }
        return false;
    }

    public function getStudentWithUserAndSubjectById($id)
    {
        return $this->model::with('user', 'subjects')->findOrFail($id);
    }

    public function updateScoreSubjectByStudentId($scores, $id)
    {
        $student = $this->find($id);
        foreach($scores as $subjectId => $score) {
            $student->subjects()->updateExistingPivot($subjectId, ['score' => $score]);
        }
    }

    public function registerSubjectsUpdate($subjectIds, $id)
    {
        $student = $this->find($id);
        $student->subjects()->attach($subjectIds);
    }

    public function updateProfileStudent($request, $user)
    {
        try {
            DB::beginTransaction();
            $data['avatar'] = $request->file('avatar') ? $request->file('avatar')->getClientOriginalName() : $user->student->avatar;
            $this->update($data, $user->student->id);
            if($request->hasFile('avatar')){
                UploadHelper::uploadFile($request);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

