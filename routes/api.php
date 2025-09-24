<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PostagemController;

// Rotas públicas
Route::prefix('usuario')->group(function () {
    Route::post('registrar-se', [UsuarioController::class, 'register']);
    Route::post('login', [UsuarioController::class, 'login']);
});

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('usuario')->group(function () {
        Route::get('perfil', [UsuarioController::class, 'perfil']);
        Route::put('atualizar', [UsuarioController::class, 'atualizar']);
        Route::put('alterar-senha', [UsuarioController::class, 'atualizarSenha']);
        Route::post('upload-foto', [UsuarioController::class, 'uploadFoto']);
        Route::post('logout', [UsuarioController::class, 'logout']);
    });

    Route::prefix('postagens')->group(function () {
        Route::get('/', [PostagemController::class, 'index']);
        Route::post('criar', [PostagemController::class, 'store']);
    });
});
