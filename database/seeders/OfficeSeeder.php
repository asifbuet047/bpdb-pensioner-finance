<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{

    public function run(): void
    {
        $offices = [
            ["officeCode" => 139, "officeName" => "RAO, P&CO, Dhaka", "officeNameInBangla" => "আহিদ, পিএন্ডসিও, বিউবো, ঢাকা", "address" => "Dhaka, Bangladesh", "mobile_no" => "01710000039", "email" => "office139@example.com"],
            ["officeCode" => 141, "officeName" => "RAO, P&D, Chittagong", "officeNameInBangla" => "আহিদ, পিএন্ডডি, বিউবো, চট্টগ্রাম", "address" => "Chittagong, Bangladesh", "mobile_no" => "01810000141", "email" => "office141@example.com"],
            ["officeCode" => 142, "officeName" => "RAO, CES, Chittagong", "officeNameInBangla" => "আহিদ, সিইএস, বিউবো, চট্টগ্রাম", "address" => "Chittagong, Bangladesh", "mobile_no" => "01910000142", "email" => "office142@example.com"],
            ["officeCode" => 143, "officeName" => "RAO, Tangail", "officeNameInBangla" => "আহিদ, বিউবো, টাঙাইল।", "address" => "Tangail, Bangladesh", "mobile_no" => "01610000143", "email" => "office143@example.com"],
            ["officeCode" => 144, "officeName" => "RAO, BPDB, Mymensingh", "officeNameInBangla" => "আহিদ, বিউবো, ময়মনসিংহ।", "address" => "Mymensingh, Bangladesh", "mobile_no" => "01710000144", "email" => "office144@example.com"],
            ["officeCode" => 145, "officeName" => "RAO, Shambhugonj, Mymensingh", "officeNameInBangla" => "আহিদ, বিউবো, শম্ভুগঞ্জ, ময়মনসিংহ", "address" => "Shambhugonj, Mymensingh", "mobile_no" => "01810000145", "email" => "office145@example.com"],
            ["officeCode" => 147, "officeName" => "RAO, Comilla", "officeNameInBangla" => "আহিদ, বিউবো, কুমিল্লা", "address" => "Comilla, Bangladesh", "mobile_no" => "01710000147", "email" => "office147@example.com"],
            ["officeCode" => 148, "officeName" => "RAO, Noakhali", "officeNameInBangla" => "আহিদ, বিউবো, নোয়াখালী", "address" => "Noakhali, Bangladesh", "mobile_no" => "01810000148", "email" => "office148@example.com"],
            ["officeCode" => 154, "officeName" => "RAO, Chittagong Power Station, Raozan", "officeNameInBangla" => "আহিদ, চট্টগ্রাম বিদ্যুৎ কেন্দ্র, বিউবো, চট্টগ্রাম", "address" => "Raozan, Chittagong", "mobile_no" => "01910000154", "email" => "office154@example.com"],
            ["officeCode" => 156, "officeName" => "RAO, Siddhiganj Power Station", "officeNameInBangla" => "আহিদ, সিদ্ধিরগঞ্জ বিদ্যুৎ কেন্দ্র, বিউবো, সিদ্ধিরগঞ্জ, নারায়নগঞ্জ", "address" => "Siddhirganj, Narayanganj", "mobile_no" => "01610000156", "email" => "office156@example.com"],
            ["officeCode" => 157, "officeName" => "RAO, Ghorashal Power Station", "officeNameInBangla" => "আহিদ, ঘোড়াশাল বিদ্যুৎ কেন্দ্র, বিউবো, পলাশ, নরসিংদী", "address" => "Ghorashal, Narsingdi", "mobile_no" => "01710000157", "email" => "office157@example.com"],
            ["officeCode" => 158, "officeName" => "RAO, Shahjibazar Power Station", "officeNameInBangla" => "আহিদ, শাহজিবাজার বিদ্যুৎ কেন্দ্র, বিউবো, শাহজিবাজার", "address" => "Shahjibazar, Bangladesh", "mobile_no" => "01810000158", "email" => "office158@example.com"],
            ["officeCode" => 159, "officeName" => "RAO, Shikalbaha Power Station", "officeNameInBangla" => "আহিদ, শিকলবাহা বিদ্যুৎ কেন্দ্র, বিউবো, চট্টগ্রাম", "address" => "Shikalbaha, Chittagong", "mobile_no" => "01910000159", "email" => "office159@example.com"],
            ["officeCode" => 161, "officeName" => "RAO, Bheramara Power Station", "officeNameInBangla" => "আহিদ, ভেড়ামারা বিদ্যুৎ কেন্দ্র, বিউবো, কুষ্টিয়া", "address" => "Bheramara, Kushtia", "mobile_no" => "01710000161", "email" => "office161@example.com"],
            ["officeCode" => 162, "officeName" => "RAO, Khulna Power Station", "officeNameInBangla" => "আহিদ, খুলনা বিদ্যুৎ কেন্দ্র, বিউবো, খুলনা", "address" => "Khulna, Bangladesh", "mobile_no" => "01810000162", "email" => "office162@example.com"],
            ["officeCode" => 163, "officeName" => "RAO, Fenchuganj Power Station", "officeNameInBangla" => "আহিদ, ফেঞ্চুগঞ্জ বিদ্যুৎ কেন্দ্র, বিউবো, সিলেট ", "address" => "Fenchuganj, Sylhet", "mobile_no" => "01910000163", "email" => "office163@example.com"],
            ["officeCode" => 164, "officeName" => "RAO, Baghabari Power Station", "officeNameInBangla" => "আহিদ, বাঘাবাড়ী বিদ্যুৎ কেন্দ্র, বিউবো, সিরাজগঞ্জ", "address" => "Baghabari, Sirajganj", "mobile_no" => "01610000164", "email" => "office164@example.com"],
            ["officeCode" => 165, "officeName" => "RAO, Barapukuria Power Station", "officeNameInBangla" => "আহিদ, বড়পুকুরিয়া কয়লা ভিত্তিক তাপ বিদ্যুৎ কেন্দ্র, বিউবো, দিনাজপুর", "address" => "Barapukuria, Dinajpur", "mobile_no" => "01710000165", "email" => "office165@example.com"],
            ["officeCode" => 487, "officeName" => "RAO, Tongi, Gazipur.", "officeNameInBangla" => "আহিদ, বিউবো, টঙ্গী, গাজীপুর", "address" => "Tongi, Gazipur", "mobile_no" => "01810000487", "email" => "office487@example.com"],
            ["officeCode" => 568, "officeName" => "RAO,Chandpur", "officeNameInBangla" => "আহিদ, বিউবো, চাঁদপুর", "address" => "Chandpur, Bangladesh", "mobile_no" => "01910000568", "email" => "office568@example.com"],
            ["officeCode" => 636, "officeName" => "RAO, Bibiyana Power Station, Habiganj", "officeNameInBangla" => "আহিদ, বিবিয়ানা বিদ্যুৎ কেন্দ্র, বিউবো, হবিগঞ্জ", "address" => "Bibiyana, Habiganj", "mobile_no" => "01710000636", "email" => "office636@example.com"],
            ["officeCode" => 1026, "officeName" => "RAO, Katakhali, Rajshahi", "officeNameInBangla" => "আহিদ, কাটাখালী, বিউবো, রাজশাহী", "address" => "Katakhali, Rajshahi", "mobile_no" => "01810001026", "email" => "office1026@example.com"],
        ];
        foreach ($offices as $office) {
            Office::create($office);
        }
    }
}
