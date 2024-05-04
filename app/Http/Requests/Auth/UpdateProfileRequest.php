<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $userId = $this->user()->id; // Assuming you have a method to get the current authenticated user

        return [
            'name'          => 'nullable|max:225',
            'phone_number'  => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'numeric',
                'min:10',
                'unique:users,phone_number,' . $userId,
            ],
            'parent_phone'  => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'numeric',
                'min:10',
                'unique:users,phone_number,' . $userId,
            ],
            //'pic_identityF' => 'required',
            //'pic_identityB' => 'required',
            'birth_date'    => 'nullable',
            'gender'        => 'nullable',
            'academic_level_id' => 'nullable|exists:academic_levels,id',
            'stage_level_id'    => 'nullable|exists:stage_levels,id',
        ];
    }
}
