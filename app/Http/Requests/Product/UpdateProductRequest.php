<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

// this rule only at update request
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:255', Rule::unique('product')->ignore($this->product),
            ],
            'description' => [
                'nullable',
            ],
            'photo' => [
                'nullable', 'image',
            ],
            'price' => [
                'required', 'integer', 'max:11',
            ],
            'is_featured' => [
                'nullable', 'boolean',
            ],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation Error.',
            'data'      => $validator->errors()
        ], 403));
    }
}
