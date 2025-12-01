<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class PaymentOfficeController extends Controller
{
    public function getAllPaymentofficeFromDB(Request $request)
    {
        if ($request->cookie('user_role') === "5") {
            $paymentoffices = Office::where('is_payment_office', true)->orderBy('officeCode')->get();
            return view('viewpaymentoffices', compact('paymentoffices'));
        } else {
            return view('login');
        }
    }
}
