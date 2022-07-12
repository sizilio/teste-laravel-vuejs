<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'cep' => 'required|unique:addresses,cep,' . $this->id,
            'logradouro' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required|size:2'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'cep.required' => 'CEP é obrigatório',
            'cep.unique' => 'CEP já existe',
            'logradouro.required' => 'Logradouro é obrigatório',
            'bairro.required' => 'Bairro é obrigatório',
            'cidade.required' => 'Cidade é obrigatório',
            'uf.required' => 'UF é obrigatório',
            'uf.size' => 'UF deve conter somente 2 letras',
        ];
    }
}
