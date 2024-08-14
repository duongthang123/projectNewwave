<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => $this->faker->unique()->regexify('0[3|5|7|8|9]\d{8}'),
            'status' => $this->faker->numberBetween(0, 2),
            'address' => $this->faker->address,
            'gender' => $this->faker->numberBetween(0, 1),
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = '2024-08-13'),
            'department_id' =>  1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Student $student) {
            $student->student_code = date('Y') . $student->user_id;
            $student->save();
        });
    }
}
