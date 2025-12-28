<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class PensionerSeeder extends Seeder
{
    public function run()
    {
        $path = resource_path('assets/pensioners.csv');

        if (!File::exists($path)) {
            $this->command->error('fake_pensioners.csv file is not found in assets folder');
            return;
        }

        DB::beginTransaction();

        try {
            $handle = fopen($path, 'r');
            $isHeader = true;

            while (($row = fgetcsv($handle, 2000)) !== false) {

                // Skip header row
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                // Skip empty ERP ID
                if (empty($row[0])) {
                    continue;
                }

                // Helper for date conversion (DD-MM-YY → YYYY-MM-DD)
                $formatDate = function ($date) {
                    if (empty($date)) {
                        return null;
                    }
                    return Carbon::createFromFormat('d-m-y', trim($date))->format('Y-m-d');
                };

                DB::table('pensioners')->updateOrInsert(
                    ['erp_id' => trim($row[0])],
                    [
                        'name' => trim($row[1]) ?? '',
                        'register_no' => trim($row[2]) ?? '',
                        'last_basic_salary' => (int) $row[3] ?? '',
                        'account_number' => (string) $row[4] ?? '',
                        'office_id' => (int) $row[5] ?? '',
                        'designation' => trim($row[6]) ?? '',
                        'pension_payment_order' => (int) $row[7] ?? '',
                        'name_bangla' => trim($row[8]) ?? '',
                        'father_name' => trim($row[9]) ?? '',
                        'mother_name' => trim($row[10]) ?? '',
                        'spouse_name' => trim($row[11]) ?? '',
                        'birth_date' => $formatDate($row[12]) ?? '',
                        'joining_date' => $formatDate($row[13]) ?? '',
                        'prl_start_date' => $formatDate($row[14]) ?? '',
                        'prl_end_date' => $formatDate($row[15]) ?? '',
                        'is_self_pension' => (int) $row[16] ?? '',
                        'phone_number' => (string) $row[17] ?? '',
                        'email' => trim($row[18]) ?? '',
                        'nid' => sprintf('%.0f', $row[19]) ?? '',
                        'religion' => (string) $row[20] ?? '',
                        'bank_routing_number' => trim($row[21]) ?? '',
                        'status' => trim($row[22]) ?? '',
                        'verified' => (int) $row[23] ?? '',
                        'biometric_verified' => (int) $row[24] ?? '',
                        'biometric_verification_type' => trim($row[25]) ?? '',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            fclose($handle);
            DB::commit();

            $this->command->info('Pensioners seeded successfully.');
        } catch (Throwable $error) {
            DB::rollBack();
            $this->command->error('CSV seeding failed: ' . $error->getMessage());
        }
    }
}
