<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Repositories\BaseRepository;

class SubjectRepository extends BaseRepository
{
    public function getModel()
    {
        return Subject::class;
    }
}

