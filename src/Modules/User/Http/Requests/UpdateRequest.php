<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                => ['required', 'string'],
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
            'id.required' => 'O ID do Usuário é obrigatório',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors' => $validator->errors()
        ], 422));
    }
}
