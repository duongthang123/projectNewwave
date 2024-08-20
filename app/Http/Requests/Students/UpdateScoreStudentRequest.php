<?php

namespace App\Http\Requests\Students;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
                        'subject_id' => 'required|numeric|exists:subjects,id',
                        'score' => 'required|numeric|min:0|max:10'
                    ]
                );

                if ($subjectValidator->fails()) {
                    foreach ($subjectValidator->errors()->all() as $message) {
                        $validator->errors()->add("scores.$subjectId", $message);
                    }
                }
            }
        });
    }

    /**
     * Override the failedValidation method to return JSON response.
     */
    protected function failedValidation(ValidationValidator $validator)
    {
        $errors = $validator->errors();
        
        toastr()->error('Update score failed!');
        session()->flash('form_data', $this->input('scores'));
        session()->flash('errors', $errors);

        throw new HttpResponseException(
            redirect()->back()->withErrors($errors)->withInput()
        );
    }
}
