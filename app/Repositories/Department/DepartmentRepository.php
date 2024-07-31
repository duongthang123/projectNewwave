<?php
namespace App\Repositories\Department;

use App\Models\Department;
use App\Repositories\BaseRepository;
use App\Repositories\Department\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseRepository
{
    public function getModel()
    {
        return Department::class;
    }
}