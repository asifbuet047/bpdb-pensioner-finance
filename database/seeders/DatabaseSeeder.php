<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([OfficeSeeder::class, DesignationSeeder::class, RoleSeeder::class, UpazilaSeeder::class, BankSeeder::class, PayscaleSeeder::class, OfficerSeeder::class, PensionerSeeder::class, PaymentOfficesBankSeeder::class]);
    }
}
