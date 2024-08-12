<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'name' => 'required|string|max:255', 
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|max:15|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|unique:students,phone,'  . $this->student,
            'birthday' => 'required|date', 
            'gender' => 'required|in:0,1', 
            'address' => 'nullable|string|max:255', 
            'status' => 'required|in:0,1,2',
            'password' => 'nullable|string|min:8|max:255',
        ];
    }
}
