<?php
namespace App\Repositories\Department;

use App\Models\Department;
use App\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    public function getModel()
    {
        return Department::class;
    }

    public function getDepartmentPluck()
    {
        return $this->model->pluck('name', 'id');
    }
}