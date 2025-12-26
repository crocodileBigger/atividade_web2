<?php

namespace App\Http\Controllers;

// Classe base para controllers
use Illuminate\Http\Request;

// Model de usuário
use App\Models\User;

// Facade para acessar o usuário autenticado
use Illuminate\Support\Facades\Auth;

/*
| UserController
| Controller responsável por:
| - Listar usuários
| - Visualizar dados de um usuário
| - Editar e atualizar usuários
| - Quitar multas (ação do bibliotecário)
|
| Todas as ações são protegidas por autenticação e Policies
*/
class UserController extends Controller
{
    /*
    | Construtor
    | Aplica o middleware de autenticação
    | Nenhuma rota deste controller pode ser acessada sem login
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    | Lista de usuários
    | - Autorização: UserPolicy@viewAny
    | - Exibe usuários paginados (10 por página)
    */
    public function index()
    {
        // Verifica se o usuário autenticado pode listar usuários
        $this->authorize('viewAny', User::class);

        // Busca usuários com paginação
        $users = User::paginate(10);

        // Retorna a view com os dados
        return view('users.index', compact('users'));
    }

    /*
    | Visualizar um usuário específico
    | - Autorização: UserPolicy@view
    | - Usa Route Model Binding
    */
    public function show(User $user)
    {
        // Verifica se pode visualizar este usuário
        $this->authorize('view', $user);

        // Exibe a view de detalhes do usuário
        return view('users.show', compact('user'));
    }

    /*
    | Formulário de edição de usuário
    | - Autorização: UserPolicy@update
    */
    public function edit(User $user)
    {
        // Verifica se pode editar o usuário
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /*
    | Atualizar dados do usuário
    | - Autorização: UserPolicy@update
    | - Validação dos dados
    | - Apenas ADMIN pode alterar o tipo do usuário
    */
    public function update(Request $request, User $user)
    {
        // Garante que o usuário tem permissão para atualizar
        $this->authorize('update', $user);

        // Validação dos campos enviados pelo formulário
        $validatedData = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'user_type' => 'nullable|in:admin,bibliotecario,cliente',
        ]);

        /*
         * Regra de segurança:
         * - Somente ADMIN pode alterar o campo user_type
         * - Usuários comuns só podem alterar nome e email
         */
        if ($request->has('user_type') && Auth::user()->isAdmin()) {

            // Admin pode atualizar tudo
            $user->update($validatedData);

        } else {

            // Usuário comum atualiza apenas nome e email
            $user->update(
                $request->only('name', 'email')
            );
        }

        // Redireciona para a lista com mensagem de sucesso
        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    /*
    | Quitar multa de um usuário
    | - Autorização: UserPolicy@pagarMulta
    | - Ação típica do bibliotecário
    | - Zera o débito no sistema após pagamento externo
    */
    public function pagarMulta(User $user)
    {
        // Verifica se o usuário autenticado pode quitar multas
        $this->authorize('pagarMulta', $user);

        // Regra de negócio no model
        $user->zerarMulta();

        // Retorna para a página anterior com sucesso
        return redirect()->back()
            ->with('success', 'Multa quitada com sucesso.');
    }
}
