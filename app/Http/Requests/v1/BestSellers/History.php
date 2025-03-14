<?php

namespace App\Http\Requests\v1\BestSellers;

use Illuminate\Foundation\Http\FormRequest;

class History extends FormRequest
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
    public function rules(): array
    {
        return [
            'author' => 'string',
            'isbn' => 'array',
            'isbn.*' => ['digits_between:10,13',function($attribute, $value, $fail) {
                if (!in_array(strlen($value),[10,13])) {
                    $fail($attribute.' length must be 10 or 13 characters.');
                }
            }],
            'title' => 'string',
            'offset' => ['integer',function($attribute, $value, $fail) {
                if (!($value % 20 == 0)) {
                    $fail($attribute.' must be a multiple of 20.');
                }
            }],
            'api-key' => 'required|string'
        ];
    }
}
