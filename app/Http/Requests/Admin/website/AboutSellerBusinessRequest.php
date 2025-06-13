<?php

namespace App\Http\Requests\Admin\website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AboutSellerBusinessRequest extends FormRequest
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
    public function rules()
    {
        return [
            /* 'title' => 'required|string|min:3|max:255',*/
            'description' => 'required|string|min:10|max:1000', 
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,webp|max:5120', // max 5MB
            
            // Listing Section
            'listing_icon' => 'required|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'listing_title' => 'required|string|max:255',
            'listing_content' => 'required|string|min:5|max:500',

            // Track Section
            'track_icon' => 'required|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'track_title' => 'required|string|max:255',
            'track_content' => 'required|string|min:5|max:500',

            // Featured Section
            'featured_icon' => 'required|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'featured_title' => 'required|string|max:255',
            'featured_content' => 'required|string|min:5|max:500',

            // Post Section
            'post_icon' => 'required|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'post_title' => 'required|string|max:255',
            'post_content' => 'required|string|min:5|max:500',
        ];
    }

    public function messages()
    {
        return [
            /* 'title.required' => 'Please enter a title.',
            'title.min' => 'Title must be at least 3 characters.',
            'title.max' => 'Title cannot exceed 255 characters.',

            'description.required' => 'Please enter a description.',
            'description.min' => 'Description must be at least 10 characters.', */
            'image.mimes' => 'Image must be a file of type: jpg, jpeg, png, svg, webp.',
            'image.max' => 'Image size must not exceed 5MB.',

            // Listing
            'listing_icon.mimes' => 'Listing icon must be jpg, jpeg, png, svg, or webp.',
            'listing_icon.max' => 'Listing icon size must not exceed 2MB.',
            'listing_title.required' => 'Please enter the listing title.',
            'listing_title.max' => 'Listing title cannot exceed 255 characters.',
            'listing_content.required' => 'Please enter listing content.',
            'listing_content.min' => 'Listing content must be at least 5 characters.',

            // Track
            'track_icon.mimes' => 'Track icon must be jpg, jpeg, png, svg, or webp.',
            'track_icon.max' => 'Track icon size must not exceed 2MB.',
            'track_title.required' => 'Please enter the track title.',
            'track_title.max' => 'Track title cannot exceed 255 characters.',
            'track_content.required' => 'Please enter track content.',
            'track_content.min' => 'Track content must be at least 5 characters.',

            // Featured
            'featured_icon.mimes' => 'Featured icon must be jpg, jpeg, png, svg, or webp.',
            'featured_icon.max' => 'Featured icon size must not exceed 2MB.',
            'featured_title.required' => 'Please enter the featured title.',
            'featured_title.max' => 'Featured title cannot exceed 255 characters.',
            'featured_content.required' => 'Please enter featured content.',
            'featured_content.min' => 'Featured content must be at least 5 characters.',

            // Post
            'post_icon.mimes' => 'Post icon must be jpg, jpeg, png, svg, or webp.',
            'post_icon.max' => 'Post icon size must not exceed 2MB.',
            'post_title.required' => 'Please enter the post title.',
            'post_title.max' => 'Post title cannot exceed 255 characters.',
            'post_content.required' => 'Please enter post content.',
            'post_content.min' => 'Post content must be at least 5 characters.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}
