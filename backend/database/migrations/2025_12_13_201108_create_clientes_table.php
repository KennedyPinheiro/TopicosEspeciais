<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Coluna tipo_pessoa já incluída na criação
            $table->enum('tipo_pessoa', ['PF', 'PJ'])->default('PF');
            
            $table->string('telefone')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->json('imagem')->nullable();
            
            // Campos para documentos
            $table->string('cpf', 11)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('razao_social')->nullable();
            $table->string('nome_fantasia')->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->date('data_fundacao_pj')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};