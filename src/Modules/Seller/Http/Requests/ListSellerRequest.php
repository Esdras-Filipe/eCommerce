<?php

namespace Modules\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ListSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function expectsJson(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page'          => ['required', 'int'],
            'perPage'       => ['sometimes', 'int'],
            'sortBy'        => ['sometimes', 'string'],
            'sortDirection' => ['sometimes', 'string'],

            'name'          => ['sometimes', 'string'],
            'slug'          => ['sometimes', 'string'],
            'document'      => ['sometimes', 'string'],
            'email'         => ['sometimes', 'email'],
            'is_active'     => ['sometimes', 'boolean'],
            'is_verified'   => ['sometimes', 'boolean'],
            'description'   => ['sometimes', 'string'],
            'currency'      => ['sometimes', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // 'page'          => '',
            // 'perPage'       => '',
            // 'sortBy'        => '',
            // 'sortDirection' => '',
            // 'name'          => '',
            // 'slug'          => '',
            // 'document'      => '',
            // 'email'         => '',
            // 'is_active'     => '',
            // 'is_verified'   => '',
            // 'description'   => '',
            // 'currency'      => '',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors' => $validator->errors()
        ], 422));
    }
}
