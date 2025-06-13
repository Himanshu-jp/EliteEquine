<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductHorseDetailsRequest extends FormRequest
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
            'sub_category' => 'required',
            'disciplines' => 'required|array|min:1',
            'disciplines.*' => 'exists:common_masters,id',
            'age' => 'required|regex:/^\d{4}$/|lte:' . date('Y'),
            'height_id' => 'required',
            'sex_id' => 'required',
            'breeds' => 'required|array|min:1',
            'breeds.*' => 'exists:common_masters,id',
            'colors' => 'required|array|min:1',
            'colors.*' => 'exists:common_masters,id',
            'training_show_experiences' => 'required|array|min:1',
            'training_show_experiences.*' => 'exists:common_masters,id',
            'green_eligibilitie_id' => 'required',
            'qualifies' => 'required|array|min:1',
            'qualifies.*' => 'exists:common_masters,id',
            'current_fence_heights' => 'required|array|min:1',
            'current_fence_heights.*' => 'exists:common_masters,id',
            'potential_fence_heights' => 'required|array|min:1',
            'potential_fence_heights.*' => 'exists:common_masters,id',
            'tried_upcoming_shows' => 'required|array|min:1',
            'tried_upcoming_shows.*' => 'exists:common_masters,id',
            'fromdate' => 'required',
            'todate' => 'required',
            'bid_min_price' => 'required',
            'sale_price' => 'required',
            'lease_price' => 'required',
            'trainer' => 'required',
            'facility' => 'required',
            'sirebloodline' => 'required',
            'dambloodline' => 'required',
            'usef' => 'required',
            'pedigree_chart' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
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
            'sub_category.required' => 'The sub-category field is required.',
            'disciplines.required' => 'At least one discipline must be selected.',
            'disciplines.array' => 'The disciplines field must be an array.',
            'disciplines.min' => 'At least one discipline must be selected.',
            'disciplines.*.exists' => 'One or more selected disciplines are invalid.',
            'age.required' => 'The age field is required.',
            'age.regex' => 'The age must be a valid 4-digit year (e.g., 1990).',
            'age.lte' => 'The year of birth cannot be greater than the current year.',
            'height_id.required' => 'The height field is required.',
            'sex_id.required' => 'The sex field is required.',
            'breed_id.required' => 'At least one breed must be selected.',
            'breed_id.array' => 'The breed field must be an array.',
            'breed_id.min' => 'At least one breed must be selected.',
            'breed_id.*.exists' => 'One or more selected breeds are invalid.',
            'color_id.required' => 'At least one color must be selected.',
            'color_id.array' => 'The color field must be an array.',
            'color_id.min' => 'At least one color must be selected.',
            'color_id.*.exists' => 'One or more selected colors are invalid.',
            'training_show_experience_id.required' => 'At least one training experience must be selected.',
            'training_show_experience_id.array' => 'The training experience field must be an array.',
            'training_show_experience_id.min' => 'At least one training experience must be selected.',
            'training_show_experience_id.*.exists' => 'One or more selected training experiences are invalid.',
            'green_eligibilitie_id.required' => 'The green eligibility field is required.',
            'qualifie_id.required' => 'At least one qualification must be selected.',
            'qualifie_id.array' => 'The qualification field must be an array.',
            'qualifie_id.min' => 'At least one qualification must be selected.',
            'qualifie_id.*.exists' => 'One or more selected qualifications are invalid.',
            'current_fence_height_id.required' => 'At least one current fence height must be selected.',
            'current_fence_height_id.array' => 'The current fence height field must be an array.',
            'current_fence_height_id.min' => 'At least one current fence height must be selected.',
            'current_fence_height_id.*.exists' => 'One or more selected current fence heights are invalid.',
            'potential_fence_height_id.required' => 'At least one potential fence height must be selected.',
            'potential_fence_height_id.array' => 'The potential fence height field must be an array.',
            'potential_fence_height_id.min' => 'At least one potential fence height must be selected.',
            'potential_fence_height_id.*.exists' => 'One or more selected potential fence heights are invalid.',
            'tried_upcoming_shows.required' => 'At least one upcoming show must be selected.',
            'tried_upcoming_shows.array' => 'The tried upcoming shows field must be an array.',
            'tried_upcoming_shows.min' => 'At least one upcoming show must be selected.',
            'tried_upcoming_shows.*.exists' => 'One or more selected upcoming shows are invalid.',
            'fromdate.required' => 'The from date field is required.',
            'todate.required' => 'The to date field is required.',
            'bid_min_price.required' => 'The bid minimum price field is required.',
            'sale_price.required' => 'The sale price field is required.',
            'lease_price.required' => 'The lease price field is required.',
            'trainer.required' => 'The trainer field is required.',
            'facility.required' => 'The facility field is required.',
            'sirebloodline.required' => 'The sire bloodline field is required.',
            'dambloodline.required' => 'The dam bloodline field is required.',
            'usef.required' => 'The USEF field is required.',
            'pedigree_chart.required' => 'The pedigree chart field is required.',
            'pedigree_chart.image' => 'The pedigree chart must be an image.',
            'pedigree_chart.mimes' => 'The pedigree chart must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'pedigree_chart.max' => 'The pedigree chart must not be greater than 2MB.',

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
