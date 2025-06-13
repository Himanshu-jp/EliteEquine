<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
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
        $categoryId = optional($this->route('category'))->id;

        return [
            'name' => ['required','string','max:255',Rule::unique('categories', 'name')->whereNull('deleted_at')->ignore($categoryId),],
            // 'slug' => ['required','string','max:255',Rule::unique('categories', 'slug')->whereNull('deleted_at')->ignore($categoryId),],
            'image' => $this->isMethod('post')
                        ? 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096'
                        : 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name of the category is required.',
            // 'slug.required' => 'The slug of the category is required.',
            // 'slug.unique' => 'The slug must be unique.',
            'image.required' => 'The image of the category is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp, or svg.',
            'image.max' => 'The image size should not exceed 4MB.',
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
