<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subcategoryId = optional($this->route('sub_category'))->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_categories')
                    ->where(function ($query) {
                        return $query->where('category_id', $this->category_id)
                                     ->whereNull('deleted_at');
                    })
                    ->ignore($subcategoryId),
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Subcategory name is required.',
            'name.unique' => 'This subcategory already exists for the selected category.',
            'category_id.required' => 'Please select a valid category.',
            'category_id.exists' => 'The selected category is invalid or has been deleted.',
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
