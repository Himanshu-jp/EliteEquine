<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Product;

class ProductListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'required|integer|min:0',
            // 'limit' => 'required|integer|min:1',
            'user_id' => 'nullable|integer',
            'category_id' => 'nullable|integer|exists:categories,id',
            'product_status' => 'nullable|string',
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
            'user_id.integer' => 'User ID must be an integer.',
            'category_id.integer' => 'Category ID must be an integer.',
            'category_id.exists' => 'The selected category does not exist.',
            'product_status.in' => 'Product status must be one of: all, live, expired, sold.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set default value for product_status if not provided
        if (!$this->has('product_status')) {
            $this->merge(['product_status' => 'all']);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $totalProducts = Product::count();

            if ($this->limit > $totalProducts) {
                $validator->errors()->add('limit', 'Limit exceeds total available products (' . $totalProducts . ').');
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $firstErrorMessage = $errors->first();

        throw new HttpResponseException(
            response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'data' => $firstErrorMessage,
            ], 422)
        );
    }
}
