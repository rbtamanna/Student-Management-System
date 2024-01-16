<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StudentEditRequest extends FormRequest
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
        $id = $this->route('id');
        $this->merge(['id' => $id]);
        $user_id = DB::table('students_info')->where('id', $id)->value('user_id');
        return [
            'id' => 'required|exists:students_info,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|unique:users,email,$user_id",
            'dob' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2560|dimensions:width=300,height=300',
            'birth_certificate' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf',
        ];
    }
}
