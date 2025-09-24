<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'picture' => 'avatar-placeholder.png',
    ]);

    return response()->json(['usuario' => $user]);
}

public function login(Request $request)
{
    if (!auth()->attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $user = auth()->user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'usuario' => $user,
        'token' => $token
    ]);
}

public function perfil()
{
    return response()->json(['usuario' => auth()->user()]);
}

public function atualizar(Request $request)
{
    $user = auth()->user();
    $user->update($request->only('name', 'email'));
    return response()->json(['message' => 'Perfil atualizado com sucesso', 'usuario' => $user]);
}

public function atualizarSenha(Request $request)
{
    $request->validate([
        'senha_atual' => 'required',
        'nova_senha' => 'required|confirmed|min:6',
    ]);

    $user = auth()->user();

    if (!\Hash::check($request->senha_atual, $user->password)) {
        return response()->json(['message' => 'Senha atual incorreta'], 400);
    }

    $user->password = bcrypt($request->nova_senha);
    $user->save();

    return response()->json(['message' => 'Senha alterada com sucesso']);
}

public function uploadFoto(Request $request)
{
    $request->validate(['foto' => 'required|image|max:2048']);
    $user = auth()->user();

    $nomeArquivo = time() . '_' . $request->foto->getClientOriginalName();
    $request->foto->move(public_path('src/imagens'), $nomeArquivo);

    $user->picture = $nomeArquivo;
    $user->save();

    return response()->json(['foto_url' => url('src/imagens/' . $nomeArquivo)]);
}

public function logout()
{
    auth()->user()->tokens()->delete();
    return response()->json(['message' => 'Logout realizado com sucesso']);
}
}