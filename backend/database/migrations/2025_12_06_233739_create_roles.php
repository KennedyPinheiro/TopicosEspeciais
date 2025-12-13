<?php
// database/migrations/2025_12_06_233739_create_roles.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'colaborador'],
            ['name' => 'cliente'],
            ['name' => 'fornecedor'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};