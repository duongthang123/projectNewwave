<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Students\CreateStudentRequest;
use App\Http\Requests\Students\ImportScoreStudentRequest;
use App\Http\Requests\Students\RegisterSubjectStudentRequest;
use App\Http\Requests\Students\UpdateProfileStudentRequest;
use App\Http\Requests\Students\UpdateScoreStudentRequest;
use App\Imports\ScoresImport;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

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
        $result = $this->studentRepo->createStudent($request);
        if($result) {
            return redirect()->route('students.index');
        }
        return redirect()->back();
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
            'error' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateStudentRequest $request, string $id)
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
        return view('admin.transcripts.student-result', compact('student'));
    }

    /**
     * update subject score by student_id
     */
    public function updateScoreByStudentId(UpdateScoreStudentRequest $request, string $id)
    {
        $result = $this->studentRepo->updateScoreSubjectByStudentId($request->scores, $id);
        if($result) {
            toastr()->success('Update score successfully!');
            return redirect()->route('students.student-result', $id);
        }
        toastr()->error('Update score failed!');
        return redirect()->back();
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

    /**
     * import scores for students by excel file
     */
    public function importScores(ImportScoreStudentRequest $request)
    {
        try {
            Excel::import(new ScoresImport, $request->file);
            toastr()->success('Import scores for students successfully');
            return redirect()->route('students.index');
        } catch (ValidationException $e) {
            toastr()->error($e->getMessage());
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->route('students.index');
        }
    }

    /**
     *  edit scores for students
     */
    public function editScores(string $id)
    {
        $student = $this->studentRepo->getStudentWithUserAndSubjectById($id);
        $subjects = $this->subjectRepo->getAll();
        return view('admin.students.edit-scores', compact('student', 'subjects'));
    }
}