<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Product;

class ProductFilterRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0|gte:price_min',
            'lease_price_min' => 'nullable|numeric|min:0',
            'lease_price_max' => 'nullable|numeric|min:0|gte:lease_price_min',
            'category_id' => 'nullable|integer|exists:categories,id',
            'feature' => 'nullable',
            'status' => 'nullable',
            'subcategory_id' => 'nullable|integer|exists:sub_categories,id',
            'page' => 'nullable|integer|min:1',
            // 'index' => 'nullable|integer|min:0',

            'sort_by' => 'nullable|in:live,expire,sold',
            'sort_order' => 'nullable|in:asc,desc',
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Title must be a string.',
            'price_min.numeric' => 'Price minimum must be a valid number.',
            'price_max.numeric' => 'Price maximum must be a valid number.',
            'price_max.gte' => 'Price max should be greater than or equal to price min.',
            
            'lease_price_min.numeric' => 'Lease price minimum must be a valid number.',
            'lease_price_max.numeric' => 'Lease price maximum must be a valid number.',
            'lease_price_max.gte' => 'Lease price max should be greater than or equal to lease price min.',
            
            'category_id.exists' => 'The selected category is invalid.',
            'subcategory_id.exists' => 'The selected subcategory is invalid.',
            'page.integer' => 'Page must be an integer.',
            // 'index.integer' => 'Index must be an integer.',
            'sort_by.in' => 'Sort by must be one of: live, expire, sold.',
            'sort_order.in' => 'Sort order must be either asc or desc.',
        ];
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
