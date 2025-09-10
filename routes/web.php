<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicationController::class, 'showHomePage'])->name('home.page');

Route::get('/addpensioner', [ApplicationController::class, 'showAddPensionerSection'])->name('add.pensioner.section');

Route::post('/addpensioner', [PensionerController::class, 'addPensionerIntoDB'])->name('add.pensioner.process');

Route::get('/pensioners', [PensionerController::class, 'showAllPensioner'])->name('show.pensioner.section');

Route::get('/login', [ApplicationController::class, 'showLoginpage'])->name('login.page');

Route::post('/login', [ApplicationController::class, 'loginOfficer'])->name('login.process');

Route::get('/logout', [ApplicationController::class, 'logout'])->name('logout');

Route::get('/registration', [ApplicationController::class, 'showRegistrationPage'])->name('registration.section');

Route::post('/registration', [OfficerController::class, 'addOfficerIntoDB'])->name('registration.process');

Route::post('/pensioner', [PensionerController::class, 'addPensionerIntoDB']);

Route::post('/officer', [OfficerController::class, 'addOfficerIntoDB']);
