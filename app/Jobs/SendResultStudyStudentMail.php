<?php

namespace App\Jobs;

use App\Mail\NotifyResultStudyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendResultStudyStudentMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $avgScore;

    /**
     * Create a new job instance.
     */
    public function __construct($student, $avgScore)
    {
        $this->student = $student;
        $this->avgScore = $avgScore;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->student->user->email)->send(new NotifyResultStudyMail($this->student, $this->avgScore));
    }
}
