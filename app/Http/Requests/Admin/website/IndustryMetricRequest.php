<?php

namespace App\Http\Requests\Admin\website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndustryMetricRequest extends FormRequest
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
            'title'       => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:3000',
            // 'icon'        => 'required|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'icon' => $this->isMethod('post')
                ? 'required|mimes:jpeg,png,jpg,gif,webp,svg|max:4096'
                : 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'Please enter a metric title',
            'title.min'          => 'Metric title must be at least 3 characters',
            'title.max'          => 'Metric title cannot exceed 255 characters',

            'description.required' => 'Please enter a metric description',
            'description.min'      => 'Description must be at least 10 characters',

            'icon.required'     => 'Please upload an icon',
            'icon.mimes'        => 'Allowed icon formats: jpg, jpeg, png, svg, webp',
            'icon.max'          => 'Icon size must not exceed 2MB',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}
