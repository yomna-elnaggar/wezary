<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompleteRequest extends FormRequest
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
            
            'pic_identityF' => 'required',
            'pic_identityB' => 'required',
            'birth_date'    => 'required',
            'gender'        => 'required',
            'academic_level_id'  => 'required|exists:academic_levels,id',
            'stage_level_id'     => 'required|exists:stage_levels,id',
           
        ];
    }

}
