<?php

use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionerController;
use Illuminate\Support\Facades\Route;

Route::get('/pensioners', [PensionerController::class, 'showAllPensioner']);

Route::get('/officers', [OfficerController::class, 'showAllOfficer']);

Route::post('/pensioner', [PensionerController::class, 'addPensionerIntoDB']);

Route::post('/officer', [OfficerController::class, 'addOfficerIntoDB']);
