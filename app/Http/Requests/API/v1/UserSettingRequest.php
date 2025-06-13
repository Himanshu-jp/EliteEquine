<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserSettingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = optional(auth()->guard('sanctum')->user())->id;

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('user_details', 'email')
                    ->whereNull('deleted_at')
                    ->ignore($userId, 'user_id')
            ],
            'phone' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],

            // Social URLs (strict validation with regex)
            'facebook' => ['required', 'url', 'regex:/^https?:\/\/(www\.)?facebook\.com\/[A-Za-z0-9_.-]+$/'],
            'twitter' => ['required', 'url', 'regex:/^https?:\/\/(www\.)?twitter\.com\/[A-Za-z0-9_]+$/'],
            'youtube' => ['required', 'url'],
            'linkedin' => ['required', 'url'],
            'instagram' => ['required', 'url'],

            'website' => ['required', 'url', 'max:300'],

            'description' => 'required|string|max:5000',
            'currency' => 'required|string|max:300',
            'precise_location' => 'required|string|max:300',
            'country' => 'required|string|max:300',
            'state' => 'required|string|max:300',
            'city' => 'required|string|max:300',
            'street' => 'required|string|max:300',
            'agree' => 'required',
            // 'banners' => 'required',
            'subscription' => 'required',
            'payment' => 'required',
            'auction' => 'required',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already in use.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be 10–15 digits and may start with a "+" sign.',

            'facebook.required' => 'Facebook URL is required.',
            'facebook.url' => 'Facebook URL must be a valid URL.',
            'facebook.regex' => 'Facebook URL must link to a valid Facebook profile.',

            'twitter.required' => 'Twitter URL is required.',
            'twitter.url' => 'Twitter URL must be a valid URL.',
            'twitter.regex' => 'Twitter URL must link to a valid Twitter profile.',

            'youtube.required' => 'YouTube URL is required.',
            'youtube.url' => 'YouTube URL must be a valid URL.',
            'youtube.regex' => 'YouTube URL must link to a valid channel, user, or custom page.',

            'linkedin.required' => 'LinkedIn URL is required.',
            'linkedin.url' => 'LinkedIn URL must be a valid URL.',
            'linkedin.regex' => 'LinkedIn URL must link to a valid profile (e.g., /in/username).',

            'instagram.required' => 'Instagram URL is required.',
            'instagram.url' => 'Instagram URL must be a valid URL.',
            'instagram.regex' => 'Instagram URL must link to a valid Instagram profile.',

            'website.required' => 'Website URL is required.',
            'website.url' => 'Website must be a valid URL.',

            'description.required' => 'Description is required.',
            'currency.required' => 'Currency is required.',
            'precise_location.required' => 'Precise location is required.',
            'country.required' => 'Country name is required.',
            'state.required' => 'State name is required.',
            'city.required' => 'City name is required.',
            'street.required' => 'Street name is required.',

            'agree.required' => 'You must agree to the terms.',
            // 'banners.required' => 'Banner is required.',
            'subscription.required' => 'Subscription setting is required.',
            'payment.required' => 'Payment setting is required.',
            'auction.required' => 'Auction setting is required.',

            'latitude.numeric' => 'Latitude must be a numeric value.',
            'latitude.between' => 'Latitude must be between -90 and 90 degrees.',

            'longitude.numeric' => 'Longitude must be a numeric value.',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees.',
        ];
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
