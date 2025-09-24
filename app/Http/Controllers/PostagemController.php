<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostagemController extends Controller
{
    /**
     * Listar todas as postagens do usuário logado
     */
    public function index()
    {
        $user = Auth::user();

        $postagens = Post::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'postagens' => $postagens
        ]);
    }

    /**
     * Criar uma nova postagem
     */
    public function store(Request $request)
    {
        $request->validate([
            'conteudo' => 'required|string',
            'description' => 'nullable|string',
            'picture' => 'nullable|string'
        ]);

        $user = Auth::user();

        $post = Post::create([
            'user_id' => $user->id,
            'conteudo' => $request->conteudo,
            'description' => $request->description ?? null,
            'picture' => $request->picture ?? null,
        ]);

        return response()->json([
            'mensagem' => 'Postagem criada com sucesso!',
            'postagem' => $post
        ]);
    }
}
