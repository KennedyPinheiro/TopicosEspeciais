<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();
                  
            $table->enum('tipo', ['FISICA', 'JURIDICA'])->default('FISICA');
            
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->json('imagem')->nullable();
            
            $table->string('cpf', 11)->nullable();
            $table->string('rg')->nullable();
            $table->date('data_nascimento')->nullable();
            
            $table->string('cnpj', 14)->nullable();
            $table->string('razao_social')->nullable();
            $table->string('nome_fantasia')->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->date('data_fundacao')->nullable();
            $table->string('responsavel')->nullable();
            
            $table->timestamps();
            
            $table->unique('cpf');
            $table->unique('cnpj');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};