<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Mostrar o formulário de edição do perfil.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('public.profile.edit', compact('user'));
    }

    /**
     * Atualizar os dados básicos do perfil (Nome e E-mail).
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            // O e-mail é único, mas ignora o ID do próprio utilizador para ele poder salvar sem dar erro
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está a ser utilizado por outra conta.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Os teus dados foram atualizados com sucesso!');
    }

    /**
     * Atualizar a palavra-passe do cliente com validação segura.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'Precisas de introduzir a tua senha atual.',
            'password.required' => 'O campo nova senha é obrigatório.',
            'password.confirmed' => 'A confirmação da nova senha não coincide.',
        ]);

        // Verifica se a senha atual digitada bate com a que está na Base de Dados
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'A senha atual introduzida está incorreta.']);
        }

        // Atualiza para a nova senha criptografada
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')->with('success_password', 'A tua palavra-passe foi alterada com sucesso!');
    }
}