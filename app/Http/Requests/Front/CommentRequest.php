<?php

namespace App\Http\Requests\Front;

namespace App\Http\Requests\Front;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class CommentRequest extends FormRequest
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
            'comment' => 'required|string|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'Content field is required',
            'comment.max' => 'The Content field must not be greater than 5000 characters.',
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