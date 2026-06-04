<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->isAdmin() || Auth::user()->role->value === 'super_admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // O nome é obrigatório, deve ser uma string, não pode passar de 255 caracteres e deve ser único na tabela categories
            'name' => 'required|string|max:255|unique:categories,name',
            
            // A descrição é opcional (nullable), mas se for enviada deve ser uma string
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.unique' => 'Já existe uma categoria registada com este nome.',
            'name.max' => 'O nome da categoria não pode ter mais de 255 caracteres.',
        ];
    }
}
