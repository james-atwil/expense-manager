<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'name'        => "string",
        'slug'        => "string",
        'description' => "string",
        'notes'       => "string",
    ])]
    public function rules() : array
    {
        return [
            'name'        => 'required',
            'slug'        => 'nullable',
            'description' => 'nullable',
            'notes'       => 'nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    #[ArrayShape(['name.required' => "string"])]
    public function messages() : array
    {
        return [
            'name.required' => __('Field is required.'),
        ];
    }
}
