<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{

    public function run(): void
    {
        $offices = config('custom.BPDB_RAO_OFFICES');
        foreach ($offices as $office) {
            Office::create($office);
        }
    }
}
