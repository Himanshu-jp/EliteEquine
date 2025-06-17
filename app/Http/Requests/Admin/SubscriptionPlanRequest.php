<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscriptionPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subscriptionPlanId = optional($this->route('subscription_plan'))->id;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subscription_plans')
                    ->where(function ($query) {
                        return $query->where('type', $this->input('type'))
                                     ->whereNull('deleted_at');
                    })
                    ->ignore($subscriptionPlanId),
            ],
            'subtitle' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'days' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'type' => 'required|in:standard,featured',
            // 'post_limit' => 'required|string|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'The combination of title and type must be unique.',
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
