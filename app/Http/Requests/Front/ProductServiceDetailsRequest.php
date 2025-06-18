<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductServiceDetailsRequest extends FormRequest
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
        $rules = [


            'job_listing_type' => 'required|array|min:1',
            'job_listing_type.*' => 'required',
            
            'service' => 'required|array|min:1',
            'service.*' => 'required',
            
            'contract_types' => 'required|array|min:1',
            'contract_types.*' => 'required',
            
            'assistance_upcoming_shows' => 'required|array|min:1',
            'assistance_upcoming_shows.*' => 'required',
            
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',

            'haulings_location_from' => 'required|string',
            'haulings_location_to' => 'required|string',
            'stalls_available_haulings' => 'required|integer',

            'salary' => 'required|numeric',
            'hourly_price' => 'required|numeric',
            'fixed_price' => 'required|numeric',
                                    
            
            'addressSet' => 'nullable',
            'contactSet' => 'nullable',
            'phone' => 'nullable|regex:/^\+?[0-9]{10,15}$/',
            'precise_location' => 'nullable|string|max:300',
            'country' => 'nullable|string|max:300',
            'state' => 'nullable|string|max:300',
            'city' => 'nullable|string|max:300',
            'street' => 'nullable|string|max:300',
            'agree' => 'required|accepted',
            'banners' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
           
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [

            'job_listing_type.required' => 'Please select at least one job listing type.',
            'service.required' => 'Please select at least one service.',
            'contract_types.required' => 'Please select at least one contract type.',
            'assistance_upcoming_shows.required' => 'Please select at least one upcoming show.',

            'fromdate.required' => 'Please enter the start date.',
            'fromdate.date' => 'Start date must be a valid date.',
            'todate.required' => 'Please enter the end date.',
            'todate.date' => 'End date must be a valid date.',
            'todate.after_or_equal' => 'End date must be after or equal to the start date.',

            'haulings_location_from.required' => 'Please enter the pickup location.',
            'haulings_location_to.required' => 'Please enter the drop-off location.',
            'stalls_available_haulings.required' => 'Please specify the number of stalls available.',
            'stalls_available_haulings.integer' => 'Stalls available must be a number.',

            'salary.required' => 'Please enter a salary amount.',
            'salary.numeric' => 'Salary must be a number.',
            'hourly_price.required' => 'Please enter the hourly price.',
            'hourly_price.numeric' => 'Hourly price must be a number.',
            'fixed_price.required' => 'Please enter the fixed price.',
            'fixed_price.numeric' => 'Fixed price must be a number.',
            

            'precise_location.required' => 'precise location field is required',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Phone number must be 10–15 digits and may start with a "+" sign.',
            'country.required' => 'Country name is required',
            'city.required' => 'City name is required',
            'state.required' => 'State name is required',
            'street.required' => 'Street name is required',            
            'banners.required' => 'Banner is required',            
            'agree.required' => 'I agree to terms of use is required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('phone', 'required', function ($input) {
            return !$input->contactSet;
        });

        foreach (['precise_location', 'country', 'state', 'city'] as $field) {
            $validator->sometimes($field, 'required|string|max:300', function ($input) {
                return !$input->addressSet;
            });
        }
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
