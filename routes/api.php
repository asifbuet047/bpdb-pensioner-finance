<?php

use App\Http\Controllers\PensionerController;
use Illuminate\Support\Facades\Route;



Route::post('/pensioner/delete', [PensionerController::class, 'removePensionerFromDB']);
