<?php

namespace Database\Seeders;

use App\Models\Officer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OfficerSeeder extends Seeder
{

    public function run(): void
    {
        $super_admins = [
            [
                'erp_id' => 140011111,
                'name' => 'Nur Ahammad Akib',
                'password' => Hash::make('Admin@123'),
                'office_id' => 211,
                'designation_id' => 1,
                'role_id' => 5,
            ],
            [
                'erp_id' => 140038764,
                'name' => 'Md. Asifuzzaman Asif',
                'password' => Hash::make('Admin@123'),
                'office_id' => 211,
                'designation_id' => 1,
                'role_id' => 5,

            ],
        ];

        foreach ($super_admins as $admin) {
            Officer::create($admin);
        }
    }
}
