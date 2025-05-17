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
            'name'               => 'required|string',
            'id_type'            => 'required|int',
            'id_no'              => 'required|int',
            'gender'             => 'required|in:male,female',
            'dob'                => 'required|date',
            'address'            => 'required|string',
            'medium_acquisition' => 'required|string',
        ];
    }
}
