<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'uid' => 'required|numeric|unique:patients,uid',
            'name' => 'required',
            'phone' => 'required',
            'coach_name' => 'required',
            'gender' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'uid.required' => 'Please enter patient ID / Iqama No.',
            'uid.numeric' => 'ID / Iqama No. must be a number.',
            'uid.unique' => 'ID / Iqama No. already registerd.',
            'name.required' => 'Please enter patient name.',
            'phone.required' => 'Please enter patient mobile.',
            'coach_name.required' => 'Please select health coach.',
            'gender.required' => 'Please select gender.'
        ];
    }
}
