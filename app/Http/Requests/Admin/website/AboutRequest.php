<?php

namespace App\Http\Requests\Admin\website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title'       => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
        ];

        // Only required on create
        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpg,jpeg,png,svg,webp|max:2048';
        } else {
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title',
            'description.required' => 'Please enter a description',
            'image.required' => 'Please upload an image',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'Allowed formats: jpg, jpeg, png, svg, webp',
            'image.max' => 'Max size is 2MB',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
