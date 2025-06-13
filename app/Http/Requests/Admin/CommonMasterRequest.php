<?php

namespace App\Http\Requests\Admin;

use App\Enums\CommonMasterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommonMasterRequest extends FormRequest
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
     */
    public function rules(): array
{
    $commonMasterId = optional($this->route('common_master'))->id;

    return [
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('common_masters')
                ->where(function ($query) {
                    return $query->where('type', $this->input('type'))
                                 ->whereNull('deleted_at');
                })
                ->ignore($commonMasterId),
        ],
        'type' => [
            'required',
            Rule::in(array_column(CommonMasterType::cases(), 'value')),
        ],
        'status' => [
            'required',
            Rule::in(['active', 'deactive']),
        ],
        'category' => [
            'required',
            'integer',
            Rule::exists('categories', 'id')->whereNull('deleted_at'),
        ],
    ];
}

    /**
     * Handle failed validation.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}
