<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
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
        $rules = [];
        if($this->has('service_job'))
        {
            $rules['service_date'] = 'required|date';
        } else {
            $rules = [
                // product
                // 'product_id' => 'required|exists:products,id',
                // Shipping


                // 'shipping_name' => 'required|string|max:100',
                // 'shipping_phone' => 'required|digits_between:7,15',
                // 'shipping_address' => 'required|string|max:255',
                // 'shipping_city' => 'required|string|max:100',
                // 'shipping_state' => 'required|string|max:100',
                // 'shipping_zip' => 'required|string|max:20',

                // Billing
                // 'billing_name' => 'required|string|max:100',
                // 'billing_phone' => 'required|digits_between:7,15',
                // 'billing_address' => 'required|string|max:255',
                // 'billing_city' => 'required|string|max:100',
                // 'billing_state' => 'required|string|max:100',
                // 'billing_zip' => 'required|string|max:20',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'The product ID is required.',
            'product_id.exists'   => 'The selected product does not exist.',
            'required' => 'This field is required.',
            'digits_between' => 'Phone must be between 7 and 15 digits.',
            'max' => 'This field exceeds maximum length.',
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
