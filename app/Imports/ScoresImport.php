<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScoresImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function collection(Collection $rows)
    // {
    //     $studentIds = $rows->pluck('student_code');
    //     $subjectIds = $rows->pluck('subject_id');

    //     $students = Student::whereIn('student_code', $studentIds)->get()->keyBy('student_code');
    //     $subjects = Subject::whereIn('id', $subjectIds)->get()->keyBy('id');
    //     $dataUpdate = [];
    //     $errors = [];

    //     foreach ($rows as $row) 
    //     { 
    //         $student = $students->get($row['student_code']);
    //         $subject = $subjects->get($row['subject_id']);

    //         if(!$student) {
    //             $errors[] = "Student code '{$row['student_code']}' does not exist";
    //         }

    //         if(!$subject) {
    //             $errors[] = "Subject_id '{$row['subject_id']}' does not exist";
    //         }

    //         if ($student && $subject) {
    //             $dataUpdate[] = [
    //                 'student_id' => $student->id,
    //                 'subject_id' => $subject->id,
    //                 'score' => $row['score'],
    //                 'updated_at' => now()
    //             ];
    //         }
    //     }

    //     if(!empty($errors)) {
    //         throw new \Exception(implode("\n", $errors));    
    //     }

    //     DB::table('student_subject')->upsert(
    //         $dataUpdate,
    //         ['student_id', 'subject_id'],
    //         ['score', 'updated_at']
    //     );
    // }

    public function collection(Collection $rows)
    {
        $studentIds = $rows->pluck('student_code');

        $students = Student::whereIn('student_code', $studentIds)->with('subjects')->get()->keyBy('student_code');
                        
        $dataUpdate = [];
        $errors = [];

        foreach ($rows as $row) 
        { 
            $student = $students->get($row['student_code']);

            if (!$student) {
                $errors[] = "Student code '{$row['student_code']}' does not exist";
                continue;
            }

            $subject = $student->subjects->where('id', $row['subject_id'])->first();

            if (!$subject) {
                $errors[] = "Subject_id '{$row['subject_id']}' does not exist for student '{$row['student_code']}'";
                continue;
            }

            $dataUpdate[] = [
                'student_id' => $student->id,
                'subject_id' => $subject->id,
                'score' => $row['score'],
                'updated_at' => now()
            ];
        }

        if (!empty($errors)) {
            throw new \Exception(implode("\n", $errors));    
        }

        DB::table('student_subject')->upsert(
            $dataUpdate,
            ['student_id', 'subject_id'],
            ['score', 'updated_at']
        );
    }

    public function rules(): array
    {
        return [
            'score' => 'nullable|numeric|min:0|max:10',
            'student_code' => 'required',
            'subject_id' => 'required|integer'
        ];
    }    

    public function chunkSize(): int
    {
        return 100;
    }
}
