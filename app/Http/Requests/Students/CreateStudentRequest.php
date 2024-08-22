<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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
        $rules = [
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => [
                'required',
                'max:15',
                'regex:/^(03|05|07|08|09)[0-9]{8}$/',
                $this->isMethod('post') ? 'unique:students,phone' : 'unique:students,phone,' . $this->student,
            ],
            'birthday' => 'required|date|before:today|after_or_equal:1900-01-01',
            'gender' => 'required|in:0,1',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:0,1,2',
            'password' => ($this->isMethod('post') ? 'required|' : 'nullable|') . 'string|min:8|max:255',
            'email' => $this->isMethod('post') ? 'required|unique:users,email|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' : '',
        ];

        return array_filter($rules);
    }
}
