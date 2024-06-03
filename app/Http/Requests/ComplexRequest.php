<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplexRequest extends FormRequest
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
            'name' => 'required',
            'city' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Enter complex name',
            'city.required' => 'Enter city'
        ];
    }
}
