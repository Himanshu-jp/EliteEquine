<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class UserProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // 'username' => 'required|string|max:255',
            'phone_no' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'bio' => 'required|string|max:3000',
            'country' => 'required|string|max:300',
            'city' => 'required|string|max:300',
            'state' => 'required|string|max:300',
            'street' => 'required|string|max:300',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Full name is required',
            'username.required' => 'User name is required',
            'phone_no.required' => 'Phone number is required',
            'phone_no.regex' => 'Phone number must be 10–15 digits and may start with a "+" sign.',
            'country.required' => 'Country name is required',
            'city.required' => 'City name is required',
            'state.required' => 'State name is required',
            'street.required' => 'Street name is required',
            'profile_photo_path.image' => 'The uploaded file must be an image.',
            'profile_photo_path.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp, or svg.',
            'profile_photo_path.max' => 'The image size should not exceed 2MB.',
            
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