<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicationController::class, 'showHomePage'])->name('home.page');

Route::get('/login', [ApplicationController::class, 'showLoginpage'])->name('login.page');

Route::post('/login', [ApplicationController::class, 'loginOfficer'])->name('login.success');

Route::get('registration', [ApplicationController::class, 'showRegistrationPage'])->name('registration.page');

Route::post('/registration', [ApplicationController::class, 'completeOfficialRegistration'])->name('registration.process');

Route::post('/pensioner', [PensionerController::class, 'addPensionerIntoDB']);

Route::post('/officer', [OfficerController::class, 'addOfficerIntoDB']);