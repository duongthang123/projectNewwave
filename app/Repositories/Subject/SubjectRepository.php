<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Repositories\BaseRepository;

use function PHPUnit\Framework\isNull;

class SubjectRepository extends BaseRepository
{
    public function getModel()
    {
        return Subject::class;
    }

    public function deleteSubject($id)
    {
        $subjectDelete = $this->model->whereDoesntHave('students', function ($query) {
            $query->whereNotNull('score');
        })->where('id', $id)->first();

        if($subjectDelete)
        {
            return $this->delete($id);
            
        }
        toastr()->error('Cannot delete subject');
        return false;
    }
}

