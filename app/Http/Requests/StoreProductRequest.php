<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        // Verifica se está autenticado e se é Admin ou Super Admin
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
            // Nome obrigatório, único na tabela de produtos
            'name' => 'required|string|max:255|unique:products,name',
            
            // Descrição opcional
            'description' => 'nullable|string',
            
            // Preço obrigatório, numérico, mínimo 0 e com até 2 casas decimais
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            
            // Stock obrigatório, número inteiro, mínimo 0
            'stock' => 'required|integer|min:0',
            
            // Status obrigatório, deve ser 'ativo' ou 'inativo'
            'status' => 'required|in:active,inactive',
            
            // Categoria obrigatória, deve existir na coluna 'id' da tabela 'categories'
            'category_id' => 'required|exists:categories,id',

            // 💡 ADICIONADO: Validação das imagens
            'images' => 'nullable|array|max:5', // Limite opcional de até 5 fotos por vez
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Cada ficheiro deve ser imagem de até 2MB
        ];
    }

    /**
     * Mensagens de erro personalizadas em português.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.unique' => 'Já existe um produto registado com este nome.',
            'price.required' => 'O preço do produto é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico válido.',
            'price.min' => 'O preço não pode ser um valor negativo.',
            'stock.required' => 'A quantidade em stock é obrigatória.',
            'stock.integer' => 'O stock deve ser um número inteiro.',
            'stock.min' => 'O stock mínimo permitido é 0.',
            'status.required' => 'O status do produto é obrigatório.',
            'status.in:active,inactive' => 'O status selecionado é inválido.',
            'category_id.required' => 'Selecione uma categoria para o produto.',
            'category_id.exists' => 'A categoria selecionada não existe no sistema.',
        ];
    }
}