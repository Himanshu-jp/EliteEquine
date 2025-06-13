<?php

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class CommunityEventsRequest extends FormRequest
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
            'title' => 'required|string|max:300',
            'requirement' => 'required|string|max:500',
            'date' => 'required',
            'time' => 'required',
            'price' => 'required|integer',
            'event_around' => 'required|string|max:1000',
            'location' => 'required|string|max:1000'
        ];

        // Only require image if the method is POST (create)
        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096';
        } else {
            // On PUT/PATCH (edit), image is optional
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not be greater than 300 characters.',
            
            'requirement.required' => 'The requirement field is required.',
            'requirement.string' => 'The requirement must be a valid string.',
            'requirement.max' => 'The requirement may not be greater than 500 characters.',
            
            'date.required' => 'The date field is required.',
            'time.required' => 'The time field is required.',
            'price.required' => 'The price field is required.',
            'price.integer' => 'The Price must be an integer.',
            
            'event_around.required' => 'The event around field is required.',
            'event_around.string' => 'The event around must be a valid string.',
            'event_around.max' => 'The event around may not be greater than 1000 characters.',
            
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a valid string.',
            'location.max' => 'The location may not be greater than 1000 characters.',

            'image.required' => 'An image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image size must not exceed 4MB.',
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