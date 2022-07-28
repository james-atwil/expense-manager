<?php

namespace App\Http\Requests\Expenses;

use App\Http\Requests\ModelRequest;
use JetBrains\PhpStorm\ArrayShape;

class ExpenseRequest extends ModelRequest
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
        'name'     => "string",
        'category' => "string",
        'amount'   => "string",
        'entry_at' => "string",
    ])]
    public function rules(): array
    {
        return [
            'name'     => 'required',
            'category' => 'required',
            'amount'   => 'required',
            'entry_at' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    #[ArrayShape([
        'name.required'     => "mixed",
        'category.required' => "mixed",
        'amount.required'   => "mixed",
        'entry_at.required' => "mixed",

    ])]
    public function messages(): array
    {
        return [
            'name.required'     => __('Field is required.'),
            'category.required' => __('Field is required.'),
            'amount.required'   => __('Field is required.'),
            'entry_at.required' => __('Field is required.'),
        ];
    }
}
