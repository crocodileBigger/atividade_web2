<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'user_type' => 'nullable|in:admin,bibliotecario,cliente',
        ]);

        // Apenas admin pode alterar user_type
        if ($request->has('user_type') && Auth::user()->isAdmin()) {
            $user->update($validatedData);
        } else {
            $user->update($request->only('name', 'email'));
        }

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }
}
