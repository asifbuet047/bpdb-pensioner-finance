<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        $designations = [
            [
                'designation_code' => 102,
                'description_english' => 'Controller',
                'description_bangla' => 'নিয়ন্ত্রক, অর্থ ও হিসাব',
                'post_type' => 'Officer',
                'order_number' => 1,
            ],
            [
                'designation_code' => 985,
                'description_english' => 'Director (Accounts/Finance/Audit/CO)',
                'description_bangla' => 'পরিচালক (হিসাব/অর্থ/অডিট/বাণিজ্যিক পরিচালন)',
                'post_type' => 'Officer',
                'order_number' => 2,
            ],
            [
                'designation_code' => 895,
                'description_english' => 'Additional Director (Accounts/Finance/Audit/CO)',
                'description_bangla' => 'অতিরিক্ত পরিচালক (হিসাব/অর্থ/অডিট/বাণিজ্যিক পরিচালন)',
                'post_type' => 'Officer',
                'order_number' => 3,
            ],
            [
                'designation_code' => 896,
                'description_english' => 'Deputy Director (Accounts/Finance/Audit/CO)',
                'description_bangla' => 'উপপরিচালক (হিসাব/অর্থ/অডিট/বাণিজ্যিক পরিচালন)',
                'post_type' => 'Officer',
                'order_number' => 4,
            ],
            [
                'designation_code' => 897,
                'description_english' => 'Senior Assistant Director (Accs/Fin./Audit/C.O.)',
                'description_bangla' => 'সিনিয়র সহকারী পরিচালক (হিসাব/অর্থ/অডিট/বাণিজ্যিক পরিচালন)',
                'post_type' => 'Officer',
                'order_number' => 5,
            ],
            [
                'designation_code' => 149,
                'description_english' => 'Assistant Director (Accounts/Finance/Audit/CO)',
                'description_bangla' => 'সহকারী পরিচালক (হিসাব/অর্থ/অডিট/বাণিজ্যিক পরিচালন)',
                'post_type' => 'Officer',
                'order_number' => 6,
            ],
            [
                'designation_code' => 181,
                'description_english' => 'Accountant',
                'description_bangla' => 'হিসাবরক্ষক',
                'post_type' => 'Officer',
                'order_number' => 7,
            ],
            [
                'designation_code' => 237,
                'description_english' => 'Assistant Accountant',
                'description_bangla' => 'সহকারী হিসাবরক্ষক',
                'post_type' => 'Staff',
                'order_number' => 8,
            ],
            [
                'designation_code' => 234,
                'description_english' => 'Senior Accounts Assistant',
                'description_bangla' => 'উচ্চমান হিসাব সহকারী',
                'post_type' => 'Staff',
                'order_number' => 9,
            ],
            [
                'designation_code' => 355,
                'description_english' => 'Junior Accounts Assistant',
                'description_bangla' => 'নিম্নমান হিসাব সহকারী',
                'post_type' => 'Staff',
                'order_number' => 10,
            ],
        ];



        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
