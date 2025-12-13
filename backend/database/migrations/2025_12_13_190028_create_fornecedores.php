<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();
                  
            $table->string('razao_social')->nullable();
            $table->string('nome_fantasia')->nullable();
            $table->string('cnpj', 14)->unique()->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email_contato')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('site')->nullable();
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};