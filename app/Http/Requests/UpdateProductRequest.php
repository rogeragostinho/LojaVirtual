<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->isAdmin() || Auth::user()->role === UserRole::SUPER_ADMIN;
    }

    /**
     * Define as regras de validação aplicadas ao pedido.
     */
    public function rules(): array
    {
        return [
            // Nome obrigatório, mas ignora a verificação 'unique' para este próprio produto
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($this->product->id),
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'categoria_id' => 'required|exists:categories,id',
        ];
    }

    /**
     * Mensagens de erro personalizadas em português.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.unique' => 'Este nome já está a ser utilizado por outro produto.',
            'price.required' => 'O preço do produto é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico válido.',
            'price.min' => 'O preço não pode ser inferior a 0.',
            'stock.required' => 'A quantidade em stock é obrigatória.',
            'stock.integer' => 'O stock deve ser um número inteiro.',
            'stock.min' => 'O stock mínimo permitido é 0.',
            'status.required' => 'O status do produto é obrigatório.',
            'status.in:active,inactive' => 'O status selecionado é inválido.',
            'categoria_id.required' => 'Selecione uma categoria para o produto.',
            'categoria_id.exists' => 'A categoria selecionada não existe no sistema.',
        ];
    }
}