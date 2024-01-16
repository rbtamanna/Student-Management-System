<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentAddRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'dob' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2560|dimensions:width=300,height=300',
            'birth_certificate' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ];
    }
}
