<?php

namespace Database\Seeders;

use App\Models\Payscale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class PayscaleSeeder extends Seeder
{
    public function run(): void
    {
        $path = resource_path('assets/payscale_2015.csv');

        if (!File::exists($path)) {
            $this->command->error('payscale_2015.csv file is not found in asset folder');
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

                $grade  = trim($row[0] ?? '');
                $step = trim($row[1] ?? '');
                $basic_salary = trim($row[2] ?? '');

                if (empty($grade)) {
                    continue;
                }

                Payscale::updateOrCreate(
                    [
                        'grade' => $grade,
                        'step' => $step,
                        'basic' => $basic_salary,
                    ]
                );
            }

            fclose($handle);
            DB::commit();

            $this->command->info('Payscale 2015 is seeded successfully.');
        } catch (Throwable $error) {
            DB::rollBack();
            $this->command->error('CSV seeding failed: ' . $error->getMessage());
        }
    }
}
