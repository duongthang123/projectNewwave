<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateScoreStudentRequest extends FormRequest
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
            'scores' => 'required|array',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $scores = $this->input('scores', []);
            
            foreach ($scores as $subjectId => $score) {
                $subjectValidator = Validator::make(
                    ['subject_id' => $subjectId, 'score' => $score],
                    [
                        'subject_id' => 'required|exists:subjects,id',
                        'score' => 'required|numeric|min:0|max:10'
                    ]
                );

                if ($subjectValidator->fails()) {
                    foreach ($subjectValidator->errors()->all() as $message) {
                        toastr()->error($message . 'Update score failed!');
                        $validator->errors()->add("scores.$subjectId", $message);
                    }
                }
            }
        });
    }
}
