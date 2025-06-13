<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email,' . $this->user()->id,
            // 'username' => 'required|string|unique:users,username,' . optional(auth()->guard('sanctum')->user())->id,
            'phone_no' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name should not exceed 255 characters.',

            /*'email.required' => 'Email address is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already in use.',*/

            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a valid string.',
            'username.unique' => 'This username is already taken.',

            'phone_no.string' => 'Phone number must be a valid string.',
            'phone_no.max' => 'Phone number should not exceed 20 characters.',

            'bio.string' => 'Bio must be a valid string.',
            'bio.max' => 'Bio should not exceed 1000 characters.',

            'profile_photo_path.image' => 'Uploaded file must be an image.',
            'profile_photo_path.mimes' => 'Image must be a JPEG, PNG, webp, or JPG file.',
            'profile_photo_path.max' => 'Image size should not exceed 2MB.',
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
                'success' => false,
                'message' => 'Validation errors',
                'data' => $firstErrorMessage
            ], 422)
        );
    }
}
