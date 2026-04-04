<?php

namespace Modules\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SellersRequests extends FormRequest
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
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'name'     => ['required', 'string'],
            'slug'     => ['required', 'string'],
            'document' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'O e-mail é obrigatório',
            'email.email'       => 'Informe um e-mail válido',
            'password.required' => 'A senha é obrigatória',
            'password.min'      => 'A senha deve ter no mínimo 6 caracteres',
            'name.required'     => 'Nome da Loja é Obrigatório',
            'slug.required'     => 'Apelido/Marca da Loja é Obrigatório',
            'document.required' => 'Número do Documento da Loja é Obrigatório',
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
