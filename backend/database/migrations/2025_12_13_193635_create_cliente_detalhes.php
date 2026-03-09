<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente_detalhes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_role_id')
                  ->constrained('user_roles')
                  ->cascadeOnDelete();
                  
            $table->decimal('limite_credito', 15, 2)->default(0);
            $table->enum('categoria', ['NORMAL', 'VIP', 'ESPECIAL'])->default('NORMAL');
            $table->date('data_adesao')->nullable();
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
        });
        
        
    }
    public function down(): void
    {
        Schema::dropIfExists('funcionario_detalhes');
  
    }
};