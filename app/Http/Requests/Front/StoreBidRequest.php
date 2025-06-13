<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\Product;

class StoreBidRequest extends FormRequest
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
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'amount' => ['required', 'numeric', 'min:0.01', function ($attribute, $value, $fail) {
                $productId = $this->input('product_id');
                $product = Product::with('highestBid', 'productDetail')->find($productId);

                if (!$product) {
                    return $fail('Invalid product.');
                }

                $minBid = optional($product->highestBid)->price ?? $product->productDetail->bid_min_price;

                if ($value <= $minBid) {
                    $fail("Your bid must be greater than $" . number_format($minBid, 2));
                }
            }],
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
