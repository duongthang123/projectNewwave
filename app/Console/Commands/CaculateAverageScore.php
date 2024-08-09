<?php

namespace App\Console\Commands;

use App\Jobs\SendResultStudyStudentMail;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CaculateAverageScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:caculate-average-score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $students = Student::whereHas('subjects', function ($query) {
            $query->whereNotNull('student_subject.score');
        })->whereDoesntHave('subjects', function ($query) {
                $query->whereNull('student_subject.score');
            })->with('subjects')->get();
        

        foreach ($students as $student) { 
            $averageScore = $student->subjects->avg('pivot.score');
            if ($averageScore < config('const.AVG_SCORE')) {
                $this->info("Student ID: {$student->id}, Name: {$student->name}, Average Score: {$averageScore}");
                SendResultStudyStudentMail::dispatch($student, $averageScore);
                $student->status = config('const.STUDENT_STATUS.EXPELLED');
                $student->save();
            }
        }
    }
}
