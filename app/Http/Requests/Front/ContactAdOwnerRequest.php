<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ContactAdOwnerRequest extends FormRequest
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
            'contactName' => 'required|string|max:255',
            'contactEmail' => 'required|email|max:255',
            'contactMessage' => 'required|string|max:5000',
        ];
    }

    public function messages(): array
    {
       return [
            'contactName.required' => 'Name is required.',
            'contactName.string' => 'Name must be a valid string.',
            'contactName.max' => 'Name should not exceed 255 characters.',

            'contactEmail.required' => 'Email is required.',
            'contactEmail.email' => 'Please enter a valid email address.',
            'contactEmail.max' => 'Email should not exceed 255 characters.',

            'contactMessage.required' => 'Message is required.',
            'contactMessage.string' => 'Message must be a valid string.',
            'contactMessage.max' => 'Message should not exceed 5000 characters.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}
