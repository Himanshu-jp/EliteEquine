<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $isEdit = $this->route('id') ?? $this->input('id');
         $rules = [
            'category' => $isEdit ? 'nullable' : 'required',
            'sale_method' => 'required|in:standard,auction',
            'transaction_method' => 'required|in:platform,buyertoseller',
            'title' => 'required|string|max:500',
            'price' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'video'   => 'nullable|array',
            'video.*' => 'mimes:mp4,mov,avi,wmv|max:20480',

            'document'   => 'nullable|array',
            'document.*'   => 'mimes:pdf,doc,docx|max:4096',

            'external_link'   => 'nullable|array',
            'external_link.*' => 'nullable|url|max:400',
            
            'video_link'   => 'nullable|array',
            'video_link.*' => 'nullable|url|max:400',

            'description' => 'required|string|max:5000',
            'bid_end_date' => ['required_if:sale_method,auction', 'nullable', 'date', 'after_or_equal:'.now()->addDays(2)->toDateString()],
        ];
        // Only require image if the method is POST (create)
        if ($this->id!=null) {            
            $rules['image'] = 'nullable|array';
            $rules['image.*'] = 'nullable|image|mimes:jpeg,png,jpg|max:4096';
        } else {
            $rules['image'] = 'nullable|required';
            $rules['image.*'] = 'required|image|mimes:jpeg,png,jpg|max:4096';
        }      

        return $rules;
    }

    public function messages()
    {
        return [
            'category.required' => 'The category field is required.',
            'sale_method.required' => 'Sale method is required.',
            'sale_method.in' => 'Sale method must be either standard or auction.',
            'transaction_method.required' => 'Transaction method is required.',
            'transaction_method.in' => 'Transaction method must be either platform or buyertoseller.',

            'title.required' => 'Title is required.',
            'title.string' => 'Title must be a valid string.',
            'title.max' => 'Title may not be greater than 500 characters.',

            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',

            'currency.required' => 'Currency is required.',
            'currency.string' => 'Currency must be a valid string.',
            'currency.max' => 'Currency may not be greater than 3 characters.',

            'image.required' => 'Please upload at least one image.',
            'image.array'    => 'Images must be provided as an array.',
            'image.*.image'  => 'Each file in images must be an image.',
            'image.*.mimes'  => 'Images must be of type jpeg, png, or jpg.',
            'image.*.max'    => 'Each image must not exceed 4MB.',

            'video.array'    => 'Videos must be provided as an array.',
            'video.*.mimes'  => 'Each video must be of type mp4, mov, avi, or wmv.',
            'video.*.max'    => 'Each video must not exceed 20MB.',

            'document.array'        => 'Documents must be provided as an array.',
            'document.*.mimes'      => 'Each document must be a file of type: pdf, doc, docx.',
            'document.*.max'        => 'Each document must not exceed 4MB.',

            'external_link.*.url' => 'External link must be a valid URL.',
            'external_link.*.max' => 'External link may not be greater than 400 characters.',
           
            'video_link.*.url' => 'Video link must be a valid URL.',
            'video_link.*.max' => 'Video link may not be greater than 400 characters.',

            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a valid string.',
            'description.max' => 'Description may not be greater than 5000 characters.',

            'bid_end_date.required_if' => 'The bid end date is required when sale method is auction.',
            'bid_end_date.after_or_equal' => 'The bid end date must be at least 2 days from today.',
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
