<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BlogRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $blogId = optional($this->route('blog'))->id;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blogs', 'title')
                    ->whereNull('deleted_at')
                    ->ignore($blogId),
            ],
            'content' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'image' => $this->isMethod('post')
                ? 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096'
                : 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
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
