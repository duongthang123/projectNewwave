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
        $students = $this->model::select('id', 'user_id', 'student_code', 'status', 'phone', 'gender', 'birthday')
                                ->with('user:id,name', 'subjects:id');
                                
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

        if (!empty($request['phone_types']) && array_filter($request['phone_types'])) {
            $phonePrefixes = array_map(function($type) {
                return config('const.PHONE_PREFIX.' . strtoupper($type));
            }, array_filter($request['phone_types']));

            if (!empty($phonePrefixes)) {
                $students->where(function($query) use ($phonePrefixes) {
                    $regexPattern = implode('|', $phonePrefixes);
                    $query->where('phone', 'regexp', $regexPattern);
                });
            }
        }

        if(!empty($request['status']) && array_filter($request['status'] , 'strlen')) {
            $students->whereIn('status', array_filter($request['status'], 'strlen'));
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
            $data['avatar'] = $request->hasFile('avatar') ? UploadHelper::uploadFile($request) : null;
            $this->create($data);
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
            if ($student) {
                $data['user_id'] = $student->user_id;
                $data['student_code'] = $student->student_code;

                if ($request->hasFile('avatar')) {
                    UploadHelper::deleteImage($student->avatar);
                    $data['avatar'] = UploadHelper::uploadFile($request);
                } else {
                    $data['avatar'] = $student->avatar;
                }

                $this->update($data, $id);
                $userData = [
                    'name' => $data['name'],
                    'email' => $student->user->email
                ];
                if ($request->password) {
                    $userData['password'] = $request->password;
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
        if ($student) {
            $data = [];
            foreach ($scores as $subjectId => $score) {
                $data[$subjectId] = ['score' => $score];
            }
            return $student->subjects()->sync($data);
        }
        return false;
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
            if ($request->hasFile('avatar')) {
                UploadHelper::deleteImage($user->student->avatar);
                $data['avatar'] = UploadHelper::uploadFile($request);
            } else {
                $data['avatar'] = $user->student->avatar;
            }
            $this->update($data, $user->student->id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

