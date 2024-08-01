<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subjects\CreateSubjectRequest;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\Repositories\Subject\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectRepo;

    public function __construct(SubjectRepository $subjectRepo)
    {
        $this->subjectRepo = $subjectRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = $this->subjectRepo->getAll();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubjectRequest $request)
    {
        $this->subjectRepo->create($request->all());
        toastr()->success(__('Create subject successfully!'));
        return redirect()->route('subjects.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = $this->subjectRepo->find($id);
        return view('admin.subjects.create', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, string $id)
    {
        $result = $this->subjectRepo->update($request->all(), $id);
        if($result) {
            toastr()->success(__('Update subject successfully!'));
            return redirect()->route('subjects.index');
        }

        toastr()->success(__('Update subject failed!'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->subjectRepo->delete($id);
        if($result) {
            toastr()->success('Delete subject successfully!');
            return response()->json([
                'error' => false
            ]);
        }
        toastr()->success('Delete subject failed!');
        return response()->json([
            'error' => true
        ]);
    }
}
