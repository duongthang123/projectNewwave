<?php

namespace App\Exports;

use App\Models\Student;
use Generator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// class StudentsExport implements FromCollection, WithHeadings, WithChunkReading
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         $students = Student::select('student_code', 'user_id')
//                             ->with('user:id,name')->take(10000)->latest('id')->get();

//         $subjectIds = [1, 9, 10, 11];

//         return $students->map(function ($student) use ($subjectIds) {
//             return [
//                 'student_code' => $student->student_code,
//                 'student_name' => $student->user->name,
//                 'subject_id' => $subjectIds[array_rand($subjectIds)],
//                 'score' => rand(0, 10),
//             ];
//         });
//     }

//     public function headings(): array
//     {
//         return [
//             'Student Code',
//             'Student Name',
//             'Subject Id',
//             'Score'
//         ];
//     }

//     public function chunkSize(): int
//     {
//         return 1000;
//     }
// }

class StudentsExport implements FromGenerator, WithHeadings
{
    use Exportable;
    public function generator(): Generator
    {
        $subjectIds = [1, 9, 10, 11];

        $query = Student::select()
            ->select('student_code')
            ->cursor();

        foreach ($query as $student) {
            yield [
                $student->student_code,
                $subjectIds[array_rand($subjectIds)], 
                rand(0, 10),
            ];
        }
    }

    public function headings(): array
    {
        return [
            'Student Code',
            'Subject Id',
            'Score'
        ];
    }
} 