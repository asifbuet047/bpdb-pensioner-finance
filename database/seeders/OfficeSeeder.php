<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{

    public function run(): void
    {
        $offices = [
            ["officeCode" => 139, "officeName" => "RAO, P&CO, Dhaka", "officeNameInBangla" => "আহিদ, পিএন্ডসিও, বিউবো, ঢাকা"],
            ["officeCode" => 141, "officeName" => "RAO, P&D, Chittagong", "officeNameInBangla" => "আহিদ, পিএন্ডডি, বিউবো, চট্টগ্রাম"],
            ["officeCode" => 142, "officeName" => "RAO, CES, Chittagong", "officeNameInBangla" => "আহিদ, সিইএস, বিউবো, চট্টগ্রাম"],
            ["officeCode" => 143, "officeName" => "RAO, Tangail", "officeNameInBangla" => "আহিদ, বিউবো, টাঙাইল।"],
            ["officeCode" => 144, "officeName" => "RAO, BPDB, Mymensingh", "officeNameInBangla" => "আহিদ, বিউবো, ময়মনসিংহ।"],
            ["officeCode" => 145, "officeName" => "RAO, Shambhugonj, Mymensingh", "officeNameInBangla" => "আহিদ, বিউবো, শম্ভুগঞ্জ, ময়মনসিংহ"],
            ["officeCode" => 147, "officeName" => "RAO, Comilla", "officeNameInBangla" => "আহিদ, বিউবো, কুমিল্লা"],
            ["officeCode" => 148, "officeName" => "RAO, Noakhali", "officeNameInBangla" => "আহিদ, বিউবো, নোয়াখালী"],
            ["officeCode" => 154, "officeName" => "RAO, Chittagong Power Station, Raozan", "officeNameInBangla" => "আহিদ, চট্টগ্রাম বিদ্যুৎ কেন্দ্র, বিউবো, চট্টগ্রাম"],
            ["officeCode" => 156, "officeName" => "RAO, Siddhiganj Power Station", "officeNameInBangla" => "আহিদ, সিদ্ধিরগঞ্জ বিদ্যুৎ কেন্দ্র, বিউবো, সিদ্ধিরগঞ্জ, নারায়নগঞ্জ"],
            ["officeCode" => 157, "officeName" => "RAO, Ghorashal Power Station", "officeNameInBangla" => "আহিদ, ঘোড়াশাল বিদ্যুৎ কেন্দ্র, বিউবো, পলাশ, নরসিংদী"],
            ["officeCode" => 158, "officeName" => "RAO, Shahjibazar Power Station", "officeNameInBangla" => "আহিদ, শাহজিবাজার বিদ্যুৎ কেন্দ্র, বিউবো, শাহজিবাজার"],
            ["officeCode" => 159, "officeName" => "RAO, Shikalbaha Power Station", "officeNameInBangla" => "আহিদ, শিকলবাহা বিদ্যুৎ কেন্দ্র, বিউবো, চট্টগ্রাম"],
            ["officeCode" => 161, "officeName" => "RAO, Bheramara Power Station", "officeNameInBangla" => "আহিদ, ভেড়ামারা বিদ্যুৎ কেন্দ্র, বিউবো, কুষ্টিয়া"],
            ["officeCode" => 162, "officeName" => "RAO, Khulna Power Station", "officeNameInBangla" => "আহিদ, খুলনা বিদ্যুৎ কেন্দ্র, বিউবো, খুলনা"],
            ["officeCode" => 163, "officeName" => "RAO, Fenchuganj Power Station", "officeNameInBangla" => "আহিদ, ফেঞ্চুগঞ্জ বিদ্যুৎ কেন্দ্র, বিউবো, সিলেট "],
            ["officeCode" => 164, "officeName" => "RAO, Baghabari Power Station", "officeNameInBangla" => "আহিদ, বাঘাবাড়ী বিদ্যুৎ কেন্দ্র, বিউবো, সিরাজগঞ্জ"],
            ["officeCode" => 165, "officeName" => "RAO, Barapukuria Power Station", "officeNameInBangla" => "আহিদ, বড়পুকুরিয়া কয়লা ভিত্তিক তাপ বিদ্যুৎ কেন্দ্র, বিউবো, দিনাজপুর"],
            ["officeCode" => 487, "officeName" => "RAO, Tongi, Gazipur.", "officeNameInBangla" => "আহিদ, বিউবো, টঙ্গী, গাজীপুর"],
            ["officeCode" => 568, "officeName" => "RAO,Chandpur", "officeNameInBangla" => "আহিদ, বিউবো, চাঁদপুর"],
            ["officeCode" => 636, "officeName" => "RAO, Bibiyana Power Station, Habiganj", "officeNameInBangla" => "আহিদ, বিবিয়ানা বিদ্যুৎ কেন্দ্র, বিউবো, হবিগঞ্জ"],
            ["officeCode" => 1026, "officeName" => "RAO, Katakhali, Rajshahi", "officeNameInBangla" => "আহিদ, কাটাখালী, বিউবো, রাজশাহী"]
        ];
        foreach ($offices as $office) {
            Office::create($office);
        }
    }
}
