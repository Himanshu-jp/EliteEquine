<?php

namespace App\Http\Requests\Admin\website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PartnershipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title'       => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:3000',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title',
            'description.required' => 'Please enter a description',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
