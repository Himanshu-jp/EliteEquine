<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserDetailsUpdateRequest extends FormRequest
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
        $userId = Auth::check() ? Auth::user()->id : null;
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255',Rule::unique('user_details', 'email')->whereNull('deleted_at')->ignore($userId, 'user_id')],
            'phone' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'facebook' => 'required|string|url|max:300',
            'twitter' => 'required|string|url|max:300',
            'youtube' => 'required|string|url|max:300',
            'linkedin' => 'required|string|url|max:300',
            'instagram' => 'required|string|url|max:300',
            'website' => 'required|string|url|max:300',
            'description' => 'required|string|max:5000',
            'currency' => 'required|string|max:300',
            'precise_location' => 'required|string|max:300',
            'country' => 'required|string|max:300',
            'state' => 'required|string|max:300',
            'city' => 'required|string|max:300',
            'street' => 'required|string|max:300',
            'agree' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            // 'banners' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'facebook.required' => 'facebook field is required',
            'twitter.required' => 'twitter field is required',
            'youtube.required' => 'youtube field is required',
            'linkedin.required' => 'linkedin field is required',
            'instagram.required' => 'instagram field is required',
            'website.required' => 'website field is required',
            'description.required' => 'description field is required',
            'currency.required' => 'currency field is required',
            'precise_location.required' => 'precise location field is required',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Phone number must be 10–15 digits and may start with a "+" sign.',
            'country.required' => 'Country name is required',
            'city.required' => 'City name is required',
            'state.required' => 'State name is required',
            'street.required' => 'Street name is required',            
            // 'banners.required' => 'Banner is required',            
            'agree.required' => 'I agree to terms of use is required',            
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