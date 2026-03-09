<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Pessoa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $adminRole = Role::where('name', 'admin')->firstOrFail();
            
            $admin = User::updateOrCreate(
                ['email' => 'Admin@admin.com'],
                [
                    'name' => 'Administrador Principal',
                    'password' => Hash::make('12345678'),
                    'role' => $adminRole->id, 
                    'primeiro_acesso' => true,
                    'email_verified_at' => now(),
                ]
            );
            
            Pessoa::updateOrCreate(
                ['user_id' => $admin->id],
                [
                    'tipo' => 'FISICA',
                    'cpf' => '00000000191',
                    'rg' => 'MG-00.000.000',
                    'telefone' => '(11) 9999-8888',
                    'celular' => '(11) 98888-7777',
                    'data_nascimento' => '1990-01-01',
                ]
            );
            
            $admin->addRole('admin');
            
            $this->command->info(" Admin configurado com role: {$adminRole->id} (admin)");
        });
    }
}