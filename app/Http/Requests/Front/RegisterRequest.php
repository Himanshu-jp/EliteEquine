<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class RegisterRequest extends FormRequest
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
            // 'email' => 'required|string|email|max:255',
            'email' => ['required','string','email','max:255',Rule::unique('users', 'email')->whereNull('deleted_at')],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed', // Ensures password_confirmation matches
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'

            ],
            'password_confirmation' => 'required',
            'opt_in_notification'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'User name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your password.',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
            'opt_in_notification.required' => 'Opt in to notifications is required.',
        ];
    }


    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         if ($this->opt_in_notification === 'yes') {
    //             if (!$this->mail && !$this->mobile && !$this->sms) {
    //                 $validator->errors()->add('contact', 'At least one of Mail, Mobile, or SMS must be selected if opting in.');
    //             }
    //         }
    //     });
    // }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }

}