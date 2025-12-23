<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionerController;
use Illuminate\Support\Facades\Route;


Route::get('/bank', [BankController::class, 'getBankDetailsByRoutingNumber']);

Route::get('/test/employeeinfo', [OfficerController::class, 'registerOfficeIntoDB']);

