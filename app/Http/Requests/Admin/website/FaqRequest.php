<?php

namespace App\Http\Requests\Admin\website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FaqRequest extends FormRequest
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
        $faqId = optional($this->route('buyer_faq'))->id;

        return [
            'question' => [
                'required',
                'string',
                'max:255',
                Rule::unique('buyer_faqs', 'questions')
                    ->whereNull('deleted_at')
                    ->ignore($faqId),
            ],
            'answer' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'question.required' => 'The question is required.',
            'question.max' => 'The question must not exceed 255 characters.',
            'question.unique' => 'This question has already been used.',

            'answer.required' => 'The answer is required.',
            'answer.min' => 'The answer must be at least 10 characters.',
        ];
    }

    /**
     * Handle failed validation and redirect back with errors.
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
