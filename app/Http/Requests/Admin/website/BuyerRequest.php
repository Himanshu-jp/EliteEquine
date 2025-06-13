<?php

namespace App\Http\Requests\Admin\website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BuyerRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $buyer = $this->route('buyer');
        $isUpdate = $buyer !== null;
        $buyerId = optional($buyer)->id;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('buyer_browsers', 'title')
                    ->ignore($buyerId)
                    ->whereNull('deleted_at'),
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
            'image' => [
                $isUpdate ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,svg,webp',
                'max:2048', // 2MB
            ],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title must not exceed 255 characters.',
            'title.unique' => 'This title has already been used.',

            'description.required' => 'The description is required.',
            'description.min' => 'The description must be at least 10 characters.',

            'image.required' => 'Please upload an image.',
            'image.image' => 'Only image files are allowed.',
            'image.mimes' => 'Accepted formats: jpg, jpeg, png, svg, webp.',
            'image.max' => 'Image size must not exceed 2MB.',
        ];
    }

    /**
     * Custom response on validation failure.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}
