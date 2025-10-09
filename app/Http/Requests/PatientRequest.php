<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $patientId = $this->route('patient') ?? $this->route('id');

        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\'-]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\'-]+$/'
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[0-9\s\-\(\)]+$/'
            ],
            'address' => [
                'required',
                'string',
                'max:255'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before_or_equal:today'
            ],
            'gender' => [
                'required',
                'in:male,female,other'
            ],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'First name can only contain letters, spaces, hyphens, and apostrophes.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Last name can only contain letters, spaces, hyphens, and apostrophes.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number format is invalid. Use only numbers, spaces, hyphens, parentheses, and + symbol.',
            'address.required' => 'Address is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before_or_equal' => 'Date of birth cannot be in the future.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be male, female, or other.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateDuplicates($validator);
        });
    }

    /**
     * Custom validation for duplicates
     */
    protected function validateDuplicates($validator)
    {
        $patientId = $this->route('patient') ?? $this->route('id');

        // Check for phone number duplicates
        $phoneDuplicate = Patient::findPatientByPhone(
            $this->input('phone'),
            $patientId
        );

        if ($phoneDuplicate) {
            $validator->errors()->add('phone', 'This phone number is already registered to another patient.');
        }

        // Check for name + DOB duplicates (same person, different contact info)
        $nameDobDuplicate = Patient::where('first_name', $this->input('first_name'))
            ->where('last_name', $this->input('last_name'))
            ->where('date_of_birth', $this->input('date_of_birth'));

        if ($patientId) {
            $nameDobDuplicate->where('_id', '!=', $patientId);
        }

        if ($nameDobDuplicate->exists()) {
            $validator->errors()->add('first_name', 'A patient with this name and date of birth already exists.');
        }
    }
}

