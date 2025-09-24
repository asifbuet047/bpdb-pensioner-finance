<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicationController::class, 'showHomePage'])->name('home.page');

Route::get('/login', [ApplicationController::class, 'showLoginpage'])->name('login.page');

Route::post('/login', [ApplicationController::class, 'loginOfficer'])->name('login.process');

Route::get('/logout', [ApplicationController::class, 'logout'])->name('logout');


Route::get('/pensioner/new', [ApplicationController::class, 'showAddPensionerSection'])->name('add.pensioner.section');

Route::get('/pensioner/update/{id}', [ApplicationController::class, 'showUpdatePensionerSection'])->name('update.pensioner.section');

Route::get('/pensioners/all', [PensionerController::class, 'getAllPensionersFromDB'])->name('show.pensioner.section');

Route::post('/pensioner', [PensionerController::class, 'addPensionerIntoDB'])->name('add.pensioner.process');

Route::post('/pensioner/remove', [PensionerController::class, 'removePensionerFromDB'])->name('remove.pensioner.process');

Route::post('/pensioner/update', [PensionerController::class, 'updatePensionerIntoDB'])->name('update.pensioner.process');

Route::get('/pensioners/download', [PensionerController::class, 'downloadPensioners'])->name('download.pensioners');



Route::get('/officer/new', [ApplicationController::class, 'showAddOfficerSection'])->name('add.officer.section');

Route::get('/officers', [OfficerController::class, 'getAllOfficersFromDB'])->name('show.officers');

Route::post('/officer', [OfficerController::class, 'addOfficerIntoDB'])->name('registration.process');

Route::post('/officer/remove', [OfficerController::class, 'removeOfficerFromDB'])->name('remove.officer.process');

Route::post('/officer/update', [OfficerController::class, 'updateOfficerIntoDB'])->name('update.officer.process');

Route::get('/officer/update/{id}', [ApplicationController::class, 'showUpdateOfficerSection'])->name('update.officer.section');

Route::get('/officers/download', [OfficerController::class, 'downloadOfficers'])->name('download.officers');


Route::get('/office/new', [ApplicationController::class, 'showAddofficeSection'])->name('add.office.section');

Route::get('/offices', [OfficeController::class, 'getAllOfficesFromDB'])->name('show.offices');

Route::post('/office', [OfficeController::class, 'addOfficeIntoDB'])->name('add.office.process');
