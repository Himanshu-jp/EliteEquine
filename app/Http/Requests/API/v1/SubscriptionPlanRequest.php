<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\SubscriptionPlan;

class SubscriptionPlanRequest extends FormRequest
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
            'type' => 'required|in:standard,featured',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Type is required.',
        ];
    }

    /**
     * Additional custom validation after the basic rules.
     */
    /* public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $totalPlans = SubscriptionPlan::count();

            if ($this->limit > $totalPlans) {
                $validator->errors()->add('limit', 'Limit exceeds total available subscription plans (' . $totalPlans . ').');
            }
        });
    } */

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
