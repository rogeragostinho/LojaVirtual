<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagementController extends Controller
{
    /**
     * Listar todos os administradores do sistema.
     */
    public function index()
    {
        // Lista apenas quem é admin ou super_admin, excluindo os clientes comuns ('user')
        $members = User::whereIn('role', ['admin', 'super_admin'])
            ->latest()
            ->paginate(10);

        return view('admin.team.index', compact('members'));
    }

    /**
     * Mostrar o formulário de criação.
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Gravar um novo administrador na Base de Dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
        ], [
            'email.unique' => 'Este e-mail já está registado no sistema.',
            'password.confirmed' => 'As palavras-passe não coincidem.',
            'password.min' => 'A palavra-passe deve ter pelo menos 8 caracteres.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()
            ->route('admin.team.index')
            ->with('success', 'Membro da equipa criado com sucesso!');
    }

    /**
     * Mostrar os detalhes de um administrador (Opcional, podes redirecionar para o edit).
     */
    public function show(User $team)
    {
        return redirect()->route('admin.team.edit', $team->id);
    }

    /**
     * Mostrar o formulário de edição.
     */
    public function edit(User $team)
    {
        // Segurança extra: impede que se edite um utilizador cliente por esta rota
        if ($team->role === 'user') {
            abort(403, 'Ação não permitida para este tipo de utilizador.');
        }

        return view('admin.team.edit', compact('team'));
    }

    /**
     * Atualizar os dados do administrador.
     */
    public function update(Request $request, User $team)
    {
        if ($team->role === 'user') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($team->id)],
            'role' => 'required|in:admin,super_admin',
            'password' => 'nullable|string|min:8|confirmed', // Senha é opcional na edição
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Se o Super Admin digitou uma nova senha, atualiza-a
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $team->update($data);

        return redirect()
            ->route('admin.team.index')
            ->with('success', 'Dados do administrador atualizados com sucesso!');
    }

    /**
     * Eliminar um administrador do sistema.
     */
    public function destroy(User $team)
    {
        // Segurança: O Super Admin não pode auto-excluir-se por acidente
        if ($team->id === auth()->id()) {
            return redirect()
                ->route('admin.team.index')
                ->with('error', 'Não podes eliminar a tua própria conta!');
        }

        $team->delete();

        return redirect()
            ->route('admin.team.index')
            ->with('success', 'Administrador removido com sucesso!');
    }
}