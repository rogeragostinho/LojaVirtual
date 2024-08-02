<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required',
            'preco' => 'required'
        ];
    }

    public function errors():array
    {
        return [
            'nome.required' => 'Um nome é obrigatório.',
            'preco.required' => 'Um preço é obrigatório',
        ];
    }
}
