<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['role_name' => 'initiator', 'permissions' => 'n/a'],
            ['role_name' => 'certifier', 'permissions' => 'n/a'],
            ['role_name' => 'approver', 'permissions' => 'n/a'],
            ['role_name' => 'admin', 'permissions' => 'n/a'],
            ['role_name' => 'super_admin', 'permissions' => 'n/a'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
