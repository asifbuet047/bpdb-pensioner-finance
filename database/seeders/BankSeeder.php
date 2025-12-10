<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class BankSeeder extends Seeder
{
    public function run(): void
    {

        $path = resource_path('assets/banks.csv');

        if (!File::exists($path)) {
            $this->command->error('Bank.csv file is not found');
            return;
        }

        DB::beginTransaction();
        try {
            $handle = fopen($path, 'r');

            $isHeader = true;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                $sl_no = trim($row[0] ?? '');
                $bank_name  = trim($row[1] ?? '');
                $branch_name = trim($row[2] ?? '');
                $routing_number = trim($row[3] ?? '');
                $branch_address = trim($row[4] ?? '');

                if (empty($routing_number)) {
                    continue;
                }

                Bank::updateOrCreate(
                    [
                        'bank_name' => $bank_name,
                        'branch_name' => $branch_name,
                        'routing_number' => $routing_number,
                        'branch_address' => $branch_address,
                    ]
                );
            }

            fclose($handle);
            DB::commit();

            $this->command->info('All bangladesh banks seeded successfully.');
        } catch (Throwable $e) {
            DB::rollBack();
            $this->command->error('CSV seeding failed: ' . $e->getMessage());
        }
    }
}
