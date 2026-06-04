<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        // Mantém a tua lógica de proteção para Admin e Super Admin
        return Auth::user()->isAdmin() || Auth::user()->role->value === 'super_admin';
    }

    /**
     * Define as regras de validação aplicadas ao pedido.
     */
    public function rules(): array
    {
        return [
            // 💡 CORRIGIDO: Usamos um array para passar a regra Rule::unique() com a exceção
            'name' => [
                'required',
                'string',
                'max:255',
                // Dizemos para ignorar o ID da categoria atual que está na rota
                Rule::unique('categories', 'name')->ignore($this->category->id),
            ],
            
            'description' => 'nullable|string',
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.unique' => 'Este nome já está a ser utilizado por outra categoria.',
            'name.max' => 'O nome da categoria não pode ter mais de 255 caracteres.',
        ];
    }
}