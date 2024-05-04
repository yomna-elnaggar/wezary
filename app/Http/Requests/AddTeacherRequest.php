<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTeacherRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:admins,email',
            'phone_number'   => 'required|unique:admins,phone_number|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
            'gender'      => 'required|string|max:255',
            'department_id'     => 'required',
            'Password' =>'required|string|min:8',
            'description' =>'required|string' ,
        ];
    }
}
