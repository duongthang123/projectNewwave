<?php
namespace App\Services\Admin;

use App\Repositories\Admin\DepartmentRepository;

class DepartmentService 
{
    protected $departmentRepositoty;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepositoty = $departmentRepository;
    }
}