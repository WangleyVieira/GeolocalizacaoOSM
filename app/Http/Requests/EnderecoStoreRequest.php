<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoStoreRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cep' => 'required|max:100',
            'endereco' => 'required|max:100',
            'numero' => 'required|max:100',
            'cidade' => 'required|max:100',
            'bairro' => 'required|max:100',
            'uf' => 'required|max:100',
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
            'cep.required' => 'CEP obrigatório.',
            'cep.max' => 'Máximo de 100 caracteres.',

            'endereco.required' => 'Endereço obrigatório.',
            'endereco.max' => 'Máximo de 100 caracteres',

            'bairro.required' => 'Bairro obrigatório.',
            'bairro.max' => 'Máximo de 100 caracteres',

            'numero.required' => 'Número obrigatório.',
            'numero.max' => 'Máximo de 100 caracteres',

            'cidade.required' => 'Cidade obrigatório.',
            'cidade.max' => 'Máximo de 100 caracteres',

            'uf.required' => 'UF obrigatório.',
            'uf.max' => 'Máximo de 100 caracteres',

        ];
    }
}
