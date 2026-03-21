<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
}
