<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'name'     => ['required'],
            'password' => ['required', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'O e-mail é obrigatório',
            'email.email'       => 'Informe um e-mail válido',
            'name.required'     => 'O Nome de Usuário é Obrigatório',
            'password.required' => 'A senha é obrigatória',
            'password.min'      => 'A senha deve ter no mínimo 6 caracteres',
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
