<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PensionerController;
use Illuminate\Support\Facades\Route;


Route::get('/bank', [BankController::class, 'getBankDetailsByRoutingNumber']);
