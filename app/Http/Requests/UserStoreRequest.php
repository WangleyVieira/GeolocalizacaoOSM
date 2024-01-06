<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirmacao' => 'required|min:6',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nome obrigatório.',
            'name.max' => 'Máximo de 255 caracteres.',

            'email.required' => 'E-mail obrigatório.',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'E-mail cadastrado no sistema',

            'password.required' => 'Senha obrigatório.',
            'password.min' => 'Senha no minímo 6 caracteres.',

            'confirmacao.required' => 'confirmacao de senha obrigatório.',
            'confirmacao.min' => 'Confirma de senha é no minímo 6 caracteres.',
        ];
    }
}
