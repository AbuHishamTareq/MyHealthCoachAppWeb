<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoachRequest extends FormRequest
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
            'uid' => 'required|numeric|unique:admins,uid',
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required',
            'complex_name' => 'required',
            'user_role' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'uid.required' => 'Please enter coach UID.',
            'uid.numeric' => 'UID must be a number.',
            'uid.unique' => 'UID already registerd.',
            'name.required' => 'Please enter coach name.',
            'email.required' => 'Please enter email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'email address already registered.',
            'password.required' => 'Please enter password.',
            'complex_name.required' => 'Please select complex name.',
            'user_role.required' => 'Please select coach role.'
        ];
    }
}
