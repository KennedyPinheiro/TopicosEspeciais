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
        Schema::table('users', function (Blueprint $table) {
      
            $table->boolean('primeiro_acesso')->default(true)->after('password');
            $table->timestamp('senha_alterada_em')->nullable()->after('primeiro_acesso');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
          
            $table->unsignedTinyInteger('role')->default(3)->after('email');
        });
    }
};
