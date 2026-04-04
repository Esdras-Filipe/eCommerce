<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'    => ['required'],
            'name'  => ['sometimes', 'string'],
            'email' => ['sometimes', 'email'],
            'role' => ['sometimes', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID do Usuário é obrigatório',
        ];
    }
}
