<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Blog;

class BlogListRequest extends FormRequest
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
            'page' => 'required|integer|min:0',
            // 'limit' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'page.required' => 'Page is required.',
            'page.integer' => 'Page must be an integer.',
            'page.min' => 'Page cannot be negative.',
            /* 'limit.required' => 'Limit is required.',
            'limit.integer' => 'Limit must be an integer.',
            'limit.min' => 'Limit must be at least 1.', */
        ];
    }

    /**
     * Additional custom validation after the basic rules.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $totalPlans = Blog::count();

            if ($this->limit > $totalPlans) {
                $validator->errors()->add('limit', 'Limit exceeds total available blogs (' . $totalPlans . ').');
            }
        });
    }

    /**
     * Customize the error response for failed validation.
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $firstErrorMessage = $errors->first();

        throw new HttpResponseException(
            response()->json([
                'status' => 422,
                'message' => 'Validation errors',
                'data' => $firstErrorMessage
            ], 422)
        );
    }
}
