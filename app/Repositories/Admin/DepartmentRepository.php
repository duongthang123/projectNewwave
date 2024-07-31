<?php

namespace App\Repositories\Admin;

use App\Models\Department;

class DepartmentRepository
{
    protected $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    
}