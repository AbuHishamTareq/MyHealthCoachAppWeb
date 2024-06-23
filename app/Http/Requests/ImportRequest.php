<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'importFile' => 'required|mimes:xlsx,xls'
        ];
    }

    public function messages()
    {
        return [
            'importFile.required' => 'Please select a file to import',
            'importFile.mimes' => 'Must be a file of type: xlsx, xls.',
        ];
    }
}
