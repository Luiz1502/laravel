<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relacionamento com users
            $table->text('conteudo'); // Conteúdo da postagem
            $table->string('description', 255)->nullable(); // Descrição opcional
            $table->string('picture', 255)->nullable(); // Foto da postagem opcional
            $table->timestamps();

            // Foreign key para garantir integridade referencial
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
