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
        return [
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'name' => 'required|string|max:255', 
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|unique:students,phone|max:15', 
            'email' => 'required|unique:users,email|email|max:255', 
            'birthday' => 'required|date', 
            'gender' => 'required|in:0,1', 
            'address' => 'nullable|string|max:255', 
            'status' => 'required|in:0,1,2',
            'password' => 'required|string|min:8',
        ];
    }
}
