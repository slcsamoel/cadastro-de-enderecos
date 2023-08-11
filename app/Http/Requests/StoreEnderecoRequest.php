<?php

namespace App\Http\Requests;

use App\Models\Endereco;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnderecoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cep' => ['required','string', 'max:10', 'unique:'.Endereco::class],
            'logradouro' => ['required', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:2'],
        ];
    }

    public function messages()
    {
        return [
            'cep.required' => 'O CEP é obrigatório.',
            'cep.unique' => 'Este CEP já está sendo usado por outro endereço.',
            'logradouro.required' => 'O logradouro é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'uf.required' => 'O estado (UF) é obrigatório.',
        ];
    }
}
