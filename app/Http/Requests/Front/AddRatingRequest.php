<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AddRatingRequest extends FormRequest
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
            'product_id'  => ['required', 'exists:products,id'],
            'rating'      => ['required', 'numeric', 'min:1', 'max:5'],
            'description' => ['required', 'string', 'max:1000'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // max 2MB
        ];
    }

    /**
     * Custom messages (optional).
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'The product ID is required.',
            'product_id.exists'   => 'The selected product does not exist.',
            'rating.required'     => 'Please provide a rating.',
            'rating.numeric'      => 'The rating must be a number.',
            'rating.min'          => 'The rating must be at least 1.',
            'rating.max'          => 'The rating may not be greater than 5.',
            'image.image'         => 'The uploaded file must be an image.',
            'image.mimes'         => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'image.max'           => 'The image must not exceed 2MB.',
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
