<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'          =>'required|max:225',
            'password'      =>'required|min:6|confirmed',
            'phone_number'  =>'required|unique:users,phone_number|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
            // 'country_code'  =>'required|numeric',
            'parent_phone'  =>'required|unique:users,phone_number|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
			//'pCountry_code' =>'required|numeric',
            // 'pic_identityF' => 'required',
            // 'pic_identityB' => 'required',
            // 'birth_date'    => 'required',
            // 'gender'        => 'required',
            // 'academic_level_id'  => 'required|exists:academic_levels,id',
            // 'stage_level_id'     => 'required|exists:stage_levels,id',
           
        ];
    }

}
