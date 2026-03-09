<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    
     public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'colaborador'],
            ['name' => 'cliente'],
            ['name' => 'fornecedor'],
            ['name' => 'funcionario'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
