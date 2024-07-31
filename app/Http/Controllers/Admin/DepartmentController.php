<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Departments\CreateDepartmentRequest;
use App\Http\Requests\Departments\UpdateDepartmentRequest;
use App\Repositories\Department\DepartmentRepository;

class DepartmentController extends Controller
{
    protected $departmentRepo;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepo = $departmentRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = $this->departmentRepo->getAll();
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDepartmentRequest $request)
    {
        $result = $this->departmentRepo->create($request->all());
        toastr()->success(__('Create department successfully!'));
        return redirect()->route('departments.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = $this->departmentRepo->find($id);
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, string $id)
    {
        $result = $this->departmentRepo->update($request->all(), $id);
        if($result) {
            toastr()->success(__('Update department successfully!'));
            return redirect()->route('departments.index');
        }

        toastr()->success(__('Update department failed!'));
        return redirect()->back();
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->departmentRepo->delete($id);
        if($result) {
            toastr()->success('Delete department successfully!');
            return response()->json([
                'error' => false
            ]);
        }
        toastr()->success('Delete department failed!');
        return response()->json([
            'error' => true
        ]);
    }
}
