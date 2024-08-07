<?php

namespace App\Http\Requests\Students;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class RegisterSubjectStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject_ids' => 'required|array',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $subjectIds = $this->input('subject_ids', []);
            $studentId = $this->route('student');

            foreach ($subjectIds as $key => $subjectId) {
                $subjectValidator = Validator::make(
                    ['subject_id' => $subjectId],
                    [
                        'subject_id' => 'required|exists:subjects,id',
                    ]
                );

                if ($subjectValidator->fails()) {
                    foreach ($subjectValidator->errors()->all() as $message) {
                        $validator->errors()->add("subject_ids.$subjectId", $message);
                    }
                    toastr()->error('Register subject errors');
                }

                $student = Student::find($studentId);
                if ($student->subjects->contains($subjectId)) {
                    $validator->errors()->add("subject_ids.$key", 'You have already registered for this subject.');
                    toastr()->error('You have already registered for one or more subjects.');
                    return;
                }
            }
        });
    }
}
