<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductBarnsDetailsRequest extends FormRequest
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
            'sub_category'=> "required",
            'property_types'=>   'required|array|min:1',
            'property_types.*' => 'exists:common_masters,id',
            'stalls_available'=> "required",
            'stable_amenities'=>   'required|array|min:1',
            'stable_amenities.*' => 'exists:common_masters,id',
            'housing_stables_around_horse_shows'=>   'required|array|min:1',
            'housing_stables_around_horse_shows.*' => 'exists:common_masters,id',
            'fromdate'=> "required",
            'todate'=> "required",
            'sleeps'=> "required",
            'housing_amenities'=>   'required|array|min:1',
            'housing_amenities.*' => 'exists:common_masters,id',
            'daily_board_rental_rate'=> "required",
            'monthly_board_rental_rate'=> "required",
            'weekly_board_rental_rate'=> "required",
            'sale_cost'=> "required",
            'realtor'=> "required",
            'property_manager'=> "required",  
            'bid_min_price' => 'required',
            
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
           
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'horse_apparel.required' => 'Please select at least one horse apparel option.',
            'horse_apparel.array' => 'Horse apparel must be an array.',
            'horse_apparel.*.exists' => 'Selected horse apparel item is invalid.',

            'rider_apparel.required' => 'Please select at least one rider apparel option.',
            'rider_apparel.array' => 'Rider apparel must be an array.',
            'rider_apparel.*.exists' => 'Selected rider apparel item is invalid.',

            'horse_tack.required' => 'Please select at least one horse tack option.',
            'horse_tack.array' => 'Horse tack must be an array.',
            'horse_tack.*.exists' => 'Selected horse tack item is invalid.',

            'trailer_trucks.required' => 'Please select at least one trailer or truck option.',
            'trailer_trucks.array' => 'Trailer trucks must be an array.',
            'trailer_trucks.*.exists' => 'Selected trailer/truck item is invalid.',

            'for_barns.required' => 'Please select at least one option for barns.',
            'for_barns.array' => 'For barns must be an array.',
            'for_barns.*.exists' => 'Selected barn item is invalid.',

            'equine_supplements.required' => 'Please select at least one equine supplement.',
            'equine_supplements.array' => 'Equine supplements must be an array.',
            'equine_supplements.*.exists' => 'Selected equine supplement item is invalid.',
            'bid_min_price.required' => 'The bid minimum price field is required.',

            'conditions.required' => 'Please select at least one condition.',
            'conditions.array' => 'Conditions must be an array.',
            'conditions.*.exists' => 'Selected condition is invalid.',

            'brands.required' => 'Please select at least one brand.',
            'brands.array' => 'Brands must be an array.',
            'brands.*.exists' => 'Selected brand is invalid.',

            'horse_sizes.required' => 'Please select at least one horse size.',
            'horse_sizes.array' => 'Horse sizes must be an array.',
            'horse_sizes.*.exists' => 'Selected horse size is invalid.',

            'rider_sizes.required' => 'Please select at least one rider size.',
            'rider_sizes.array' => 'Rider sizes must be an array.',
            'rider_sizes.*.exists' => 'Selected rider size is invalid.',

            'exchanged_upcoming_horse_shows.required' => 'Please select at least one upcoming horse show.',
            'exchanged_upcoming_horse_shows.array' => 'Upcoming horse shows must be an array.',
            'exchanged_upcoming_horse_shows.*.exists' => 'Selected horse show is invalid.',

            'price.required' => 'Price is required.',
            'hourly_price.required' => 'Hourly price is required.',
            'fixed_price.required' => 'Fixed price is required.',

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

        foreach (['precise_location', 'country', 'state', 'city', 'street'] as $field) {
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
