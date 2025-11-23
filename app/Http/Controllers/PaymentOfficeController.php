<?php

namespace App\Http\Controllers;

use App\Models\PaymentOffice;
use Illuminate\Http\Request;

class PaymentOfficeController extends Controller
{
    public function getAllPaymentofficeFromDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {
            $paymentoffices = PaymentOffice::with('office')->orderBy('officeCode')->get();
            return view('viewpaymentoffices', compact('paymentoffices'));
        } else {
            return view('login');
        }
    }
}
