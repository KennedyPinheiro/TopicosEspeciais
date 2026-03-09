<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionario_detalhes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_role_id')
                  ->constrained('user_roles')
                  ->cascadeOnDelete();
                  
            $table->string('cargo')->nullable();
            $table->decimal('salario', 10, 2)->nullable();
            $table->date('data_admissao')->nullable();
            $table->date('data_demissao')->nullable();
            $table->string('ctps')->nullable();
            $table->string('pis')->nullable();
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionario_detalhes');
    }
};