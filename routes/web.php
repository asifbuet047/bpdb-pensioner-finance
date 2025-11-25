<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionerController;
use App\Http\Controllers\PensionerCredentialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicationController::class, 'showHomePage'])->name('home.page');

Route::get('/login', [ApplicationController::class, 'showLoginpage'])->name('login.page');

Route::post('/login', [ApplicationController::class, 'login'])->name('login.process');

Route::get('/set', [ApplicationController::class, 'showSetPasswordForPensionerPage'])->name('set.password.page');

Route::post('/set', [PensionerCredentialController::class, 'addPensionerCredentialIntoDB'])->name('set.password.process');

Route::get('/logout', [ApplicationController::class, 'logout'])->name('logout');


Route::get('/pensioner/new', [ApplicationController::class, 'showAddPensionerSection'])->name('add.pensioner.section');

Route::get('/pensioner/update/{id}', [ApplicationController::class, 'showUpdatePensionerSection'])->name('update.pensioner.section');

Route::get('/pensioners/all', [PensionerController::class, 'getAllPensionersFromDB'])->name('show.pensioner.section');

Route::post('/pensioner', [PensionerController::class, 'addPensionerIntoDB'])->name('add.pensioner.process');

Route::post('/pensioner/remove', [PensionerController::class, 'removePensionerFromDB'])->name('remove.pensioner.process');

Route::post('/pensioner/update', [PensionerController::class, 'updatePensionerIntoDB'])->name('update.pensioner.process');

Route::get('/pensioners/export', [PensionerController::class, 'exportPensioners'])->name('download.pensioners');

Route::get('/pensioners/export/template', [PensionerController::class, 'exportPensionersTemplate'])->name('download.template.pensioners');

Route::post('pensioners/import', [PensionerController::class, 'importPensioner'])->name('import.pensioners');

Route::get('pensioners/import', [PensionerController::class, 'showImportPensionerSection'])->name('import.pentioners.section');

Route::get('/pensioners/bank', [PensionerController::class, 'showInvoiceBank'])->name('show.invoice.bank');

Route::get('/pensioners/invoice', [PensionerController::class, 'showSelectedBankPensionersForInvoiceGeneration'])->name('show.invoice');

Route::get('pensioners/invoice/generate', [PensionerController::class, 'generateInvoice'])->name('generate.invoice');


Route::get('/officer/new', [ApplicationController::class, 'showAddOfficerSection'])->name('add.officer.section');

Route::get('/officers', [OfficerController::class, 'getAllOfficersFromDB'])->name('show.officers');

Route::post('/officer', [OfficerController::class, 'addOfficerIntoDB'])->name('registration.process');

Route::post('/officer/remove', [OfficerController::class, 'removeOfficerFromDB'])->name('remove.officer.process');

Route::post('/officer/update', [OfficerController::class, 'updateOfficerIntoDB'])->name('update.officer.process');

Route::get('/officer/update/{id}', [ApplicationController::class, 'showUpdateOfficerSection'])->name('update.officer.section');

Route::get('/officers/export', [OfficerController::class, 'exportOfficers'])->name('download.officers');

Route::get('/officers/export/template', [OfficerController::class, 'downloadOfficers'])->name('download.template.officers');

Route::get('/search-offices', [OfficeController::class, 'search']);


Route::get('/office/new', [ApplicationController::class, 'showAddofficeSection'])->name('add.office.section');

Route::get('/offices', [OfficeController::class, 'getAllOfficesFromDB'])->name('show.offices');

Route::get('/paymentoffices', [OfficeController::class, 'getAllPaymentOfficesFromDB'])->name('show.payment.offices');

Route::get('/unitoffices', [OfficeController::class, 'getAllUnitOfficesFromDB'])->name('show.unit.offices');

Route::post('/office', [OfficeController::class, 'addOfficeIntoDB'])->name('add.office.process');
