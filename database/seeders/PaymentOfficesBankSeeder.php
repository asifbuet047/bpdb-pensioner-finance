<?php

namespace Database\Seeders;

use App\Models\PaymentOfficesBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Throwable;

class PaymentOfficesBankSeeder extends Seeder
{

    public function run(): void
    {

        $path = resource_path('assets/payment_offices_bank.csv');

        if (!File::exists($path)) {
            $this->command->error('payment_offices_bank.csv file is not found');
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

                $routing_number = trim($row[0] ?? '');
                $account_name  = trim($row[1] ?? '');
                $account_number = trim($row[2] ?? '');
                $erp_bank_code = trim($row[3] ?? '');
                $office_id = trim($row[4] ?? '');

                if (empty($routing_number)) {
                    continue;
                }

                PaymentOfficesBank::updateOrCreate(
                    [
                        'routing_number' => $routing_number,
                        'account_name' => $account_name,
                        'account_number' => $account_number,
                        'erp_bank_code' => $erp_bank_code,
                        'office_id' => $office_id,
                    ]
                );
            }

            fclose($handle);
            DB::commit();

            $this->command->info('All payment offices banks seeded successfully.');
        } catch (Throwable $e) {
            DB::rollBack();
            $this->command->error('CSV seeding failed: ' . $e->getMessage());
        }
    }
}
