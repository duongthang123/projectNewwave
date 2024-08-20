<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;

class GenerateFakeStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-fake-students {count=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '512M');
        $count = $this->argument('count');
        for ($i = 0; $i < $count; $i++) {
            Student::factory()->count(1000)->create();
            $this->info("Created " . (($i + 1) * 10) . " students");
        }
    }
}
