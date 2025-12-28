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
                'designation_id' => 5,
                'role_id' => 5,
            ],
            [
                'erp_id' => 140038764,
                'name' => 'Md. Asifuzzaman Asif',
                'password' => Hash::make('Admin@123'),
                'office_id' => 211,
                'designation_id' => 5,
                'role_id' => 5,

            ],
            [
                'erp_id' => 140012234,
                'name' => 'Mohammed Salim',
                'password' => Hash::make('admin@123'),
                'office_id' => 30,
                'designation_id' => 4,
                'role_id' => 3,

            ],
            [
                'erp_id' => 140043208,
                'name' => 'Md. Rajib',
                'password' => Hash::make('admin@123'),
                'office_id' => 30,
                'designation_id' => 6,
                'role_id' => 2,

            ],
            [
                'erp_id' => 140036577,
                'name' => 'Md. Obaidul Islam',
                'password' => Hash::make('admin@123'),
                'office_id' => 30,
                'designation_id' => 8,
                'role_id' => 1,

            ],
            [
                'erp_id' => 140036565,
                'name' => 'Bimal Kumar Singha',
                'password' => Hash::make('admin@123'),
                'office_id' => 29,
                'designation_id' => 4,
                'role_id' => 1,

            ],

        ];

        foreach ($super_admins as $admin) {
            Officer::create($admin);
        }
    }
}
