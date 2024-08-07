<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\CreateStudentRequest;
use App\Http\Requests\Students\RegisterSubjectStudentRequest;
use App\Http\Requests\Students\UpdateProfileStudentRequest;
use App\Http\Requests\Students\UpdateScoreStudentRequest;
use App\Http\Requests\Students\UpdateStudentRequest;
use App\Jobs\SendAccountStudentMail;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected $studentRepo;
    protected $departmentRepo;
    protected $userRepo;
    protected $subjectRepo;

    public function __construct (
        StudentRepository $studentRepo, 
        DepartmentRepository $departmentRepo, 
        UserRepository $userRepo,
        SubjectRepository $subjectRepo
    ){
        $this->studentRepo = $studentRepo;
        $this->departmentRepo = $departmentRepo;
        $this->userRepo = $userRepo;
        $this->subjectRepo = $subjectRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = $this->studentRepo->fillter($request->all());
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = $this->departmentRepo->getDepartmentPluck();
        return view('admin.students.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStudentRequest $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();

            $user = $this->userRepo->create($data);

            $data['user_id'] = $user->id;
            $data['student_code'] = date('Y') . $user->id;
            $data['avatar'] = $request->file('avatar') ? $request->file('avatar')->getClientOriginalName() : '';
            
            $this->studentRepo->create($data);
            if($request->hasFile('avatar')){
                UploadHelper::uploadFile($request);
            }
            SendAccountStudentMail::dispatch($data);
            DB::commit();

            toastr()->success('Create student successfully!');
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Create student failed!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = $this->studentRepo->getStudentByIdWithUser($id);
        $departments = $this->departmentRepo->getDepartmentPluck();
        return view('admin.students.show', compact('student', 'departments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = $this->studentRepo->getStudentByIdWithUser($id);
        $studentThumb = $student->avatar_url;
        $departments = $this->departmentRepo->getAll();
        if($student) {
            return response()->json([
                'error' => false,
                'student' => $student,
                'studentThumb' => $studentThumb,
                'departments' => $departments
            ]);
        }

        return response()->json([
            'error' => false
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $result = $this->studentRepo->updateStudent($request, $id);
        if($result) {
            toastr()->success('Update student successfully!');
            return response()->json([
                'error' => false,
            ]);
        }
        return response()->json([
            'error' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->studentRepo->deleteStudent($id);
        if($result) {
            toastr()->success('Delete student successfully!');
            return response()->json([
                'error' => false
            ]);
        }
        toastr()->error('Delete student failed!');
        return response()->json([
            'error' => true
        ]);
    }

    /**
     * get student transcripts by student_id
     */
    public function getStudentTranscriptById(string $id)
    {
        $student = $this->studentRepo->getStudentWithUserAndSubjectById($id);
        $avgScore = $student->subjects->avg('pivot.score');
        return view('admin.transcripts.student-result', compact('student', 'avgScore'));
    }

    /**
     * update subject score by student_id
     */
    public function updateScoreSubjectByStudentId(UpdateScoreStudentRequest $request, string $id)
    {
        $this->studentRepo->updateScoreSubjectByStudentId($request->scores, $id);
        toastr()->success('Update score successfully!');
        return response()->json([
            'error' => false,
        ]);
    }

    /**
     * show form register subjects for students
     */
    public function registerSubjects(Request $request, string $id)
    {
        $student = $this->studentRepo->getStudentWithUserAndSubjectById($id);
        $subjectStudent = $student->subjects->pluck('id')->toArray();
        $subjects = $this->subjectRepo->getAll($request->per_page);
        return view('admin.students.register-subject', compact('student', 'subjectStudent' , 'subjects'));
    }

    /**
     *   register subjects for students
     */
    public function registerSubjectsUpdate(RegisterSubjectStudentRequest $request, string $id)
    {
        $this->studentRepo->registerSubjectsUpdate($request->subject_ids, $id);
        toastr()->success('Register subjects successfully!');
        return redirect()->route('students.register-subjects', $id);
    }

    /**
     * student profile
     */
    public function profileStudent()
    {
        $user = auth()->user();
        return view('admin.students.profile', compact('user'));
    }

    /**
     * update student profile
     */
    public function updateProfileStudent(UpdateProfileStudentRequest $request)
    {
        $result = $this->studentRepo->updateProfileStudent($request, auth()->user());
        if($result) {
            toastr()->success('Update profile successfully!');
            return redirect()->route('students.profile');
        }
        return redirect()->back();
    }
}