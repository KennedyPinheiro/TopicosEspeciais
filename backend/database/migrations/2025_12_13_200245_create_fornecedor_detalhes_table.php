<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fornecedor_detalhes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_role_id')
                  ->constrained('user_roles')
                  ->cascadeOnDelete();
                  
            $table->integer('prazo_pagamento')->default(30);
            $table->string('contato_compras')->nullable();
            $table->enum('categoria', ['MATERIA_PRIMA', 'SERVICO', 'PRODUTO'])->default('MATERIA_PRIMA');
            $table->decimal('limite_compra', 15, 2)->default(0);
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fornecedor_detalhes');
    }
};