<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class OfficeSeeder extends Seeder
{

    public function run(): void
    {

        $path = resource_path('assets/offices.csv');

        if (!File::exists($path)) {
            $this->command->error('Offices.csv file is not found in asset folder');
            return;
        }

        DB::beginTransaction();
        try {
            $handle = fopen($path, 'r');

            $isHeader = true;

            while (($row = fgetcsv($handle, 1000)) !== false) {
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                $office_code  = trim($row[0] ?? '');
                $name_in_english = trim($row[1] ?? '');
                $name_in_bangla = trim($row[2] ?? '');
                $address = trim($row[3] ?? '');
                $mobile_no = trim($row[4] ?? '');
                $email = trim($row[5] ?? '');
                $is_payment_office = $row[6] === 'TRUE' ? true : false;
                $payment_office_code = trim($row[7] ?? '');

                if (empty($office_code)) {
                    continue;
                }

                Office::updateOrCreate(
                    [
                        'office_code' => $office_code,
                        'name_in_english' => $name_in_english,
                        'name_in_bangla' => $name_in_bangla,
                        'address' => $address,
                        'mobile_no' => $mobile_no,
                        'email' => $email,
                        'is_payment_office' => $is_payment_office,
                        'payment_office_code' => (int) $payment_office_code,
                    ]
                );
            }

            fclose($handle);
            DB::commit();

            $this->command->info('Offices are seeded successfully.');
        } catch (Throwable $error) {
            DB::rollBack();
            $this->command->error('CSV seeding failed: ' . $error->getMessage());
        }
    }
}
