<?php

namespace App\Http\Requests\System;

use App\Http\Requests\ModelRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserRequest extends ModelRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
    #[ArrayShape([
        'email'        => "string",
        'role'         => "string",
        'password'     => "string",
        'name_display' => "string",
        'notes'        => "string",
    ])]
    public function rules(): array
    {
        return [
            'email'        => 'required',
            'role'         => 'required',
            'password'     => 'nullable',
            'name_display' => 'nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    #[ArrayShape([
        'email.required'        => "mixed",
        'email.invalid'         => "mixed",
        'name_display.required' => "mixed",

    ])]
    public function messages(): array
    {
        return [
            'email.required'        => __('Field is required.'),
            'email.invalid'         => __('Must be a valid email address.'),
            'name_display.required' => __('Field is required.'),
        ];
    }
}
