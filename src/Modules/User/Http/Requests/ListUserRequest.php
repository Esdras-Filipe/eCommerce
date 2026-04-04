<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ListUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page'              => ['required', 'int'],
            'perPage'           => ['sometimes', 'int'],
            'sortBy'            => ['required', 'string'],
            'sortDirection'     => ['sometimes', 'string'],

            'name'              => ['sometimes', 'string'],
            'email'             => ['sometimes', 'email'],
            'role'              => ['sometimes', 'string'],
            'email_verified_at' => ['sometimes', 'date'],
            'remember_token'    => ['sometimes', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'page.required'   => 'O Número da Página é obrigatório',
            'sortBy.required' => 'O Campo para Ordenação é Obrigatório',
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
