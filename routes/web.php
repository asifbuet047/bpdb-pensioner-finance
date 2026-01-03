<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionController;
use App\Http\Controllers\PensionerController;
use App\Http\Controllers\PensionerCredentialController;
use App\Http\Controllers\PensionerspensionblockmessageController;
use App\Http\Controllers\PensionerspensionController;
use App\Http\Controllers\PensionerworkflowController;
use App\Http\Controllers\PensionworkflowController;
use App\Models\Pensionerspensionblockmessage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages & Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ApplicationController::class, 'showHomePage'])->name('home.page');
Route::get('/login', [ApplicationController::class, 'showLoginpage'])->name('login.page');
Route::post('/login', [ApplicationController::class, 'login'])->name('login.process');
Route::get('/logout', [ApplicationController::class, 'logout'])->name('logout');
Route::get('/set', [ApplicationController::class, 'showSetPasswordForPensionerPage'])->name('set.password.page');
Route::get('/pensioner/new', [ApplicationController::class, 'showAddPensionerVariantSection'])->name('add.pensioner.section');
Route::get('/pensioner/add/erp', [ApplicationController::class, 'showAddPensionerByErpSection'])->name('add.pensioner.erp.section');
Route::get('/pensioner/add/form', [ApplicationController::class, 'showAddPensionerByFillingFormSection'])->name('add.pensioner.form.section');
Route::get('/pensioner/search', [ApplicationController::class, 'showPensionerSearchSection'])->name('search.pensioner.section');
Route::get('/pensioner/update/{id}', [ApplicationController::class, 'showUpdatePensionerSection'])->name('update.pensioner.section');
Route::get('/officer/new', [ApplicationController::class, 'showAddOfficerSection'])->name('add.officer.section');
Route::get('/officer/search', [ApplicationController::class, 'showOfficerSearchSection'])->name('search.officer.section');
Route::get('/officer/update/{id}', [ApplicationController::class, 'showUpdateOfficerSection'])->name('update.officer.section');
Route::get('/office/new', [ApplicationController::class, 'showAddofficeSection'])->name('add.office.section');
Route::get('/send-mail', [ApplicationController::class, 'sendTestMail']);
Route::get('/pensioner/apply', [ApplicationController::class, 'showPensionerPensionApplyForm'])->name('pensioner.pension.apply.form');



Route::post('/set', [PensionerCredentialController::class, 'addPensionerCredentialIntoDB'])->name('set.password.process');



Route::post('/pensioner/search', [PensionerController::class, 'searchPensionerByErp'])->name('search.pensioner.erp.process');
Route::get('/pensioners', [PensionerController::class, 'showPensionersVariantSection'])->name('show.pensioners.variant.section');
Route::get('/pensioners/all', [PensionerController::class, 'getAllPensionersFromDB'])->name('show.pensioner.section');
Route::post('/pensioner', [PensionerController::class, 'addPensionerIntoDB'])->name('add.pensioner.process');
Route::delete('/pensioner/{id}', [PensionerController::class, 'deletePensionerFromDB']);
Route::get('/pensioner/update/{id}', [PensionerController::class, 'getSpecificPensionerFromDB']);
Route::post('/pensioner/update', [PensionerController::class, 'updatePensionerIntoDB'])->name('update.pensioner.process');
Route::get('/api/pensioner/{id}', [PensionerController::class, 'isPensionerExits']);
Route::get('/api/pensioners/approved', [PensionerController::class, 'getApprovedPensioners']);
Route::get('/pensioners/export', [PensionerController::class, 'exportPensioners'])->name('download.pensioners');
Route::get('/pensioners/export/template', [PensionerController::class, 'exportPensionersTemplate'])->name('download.template.pensioners');
Route::get('/pensioners/import', [PensionerController::class, 'showImportPensionerSection'])->name('import.pentioners.section');
Route::post('/pensioners/import', [PensionerController::class, 'importPensioner'])->name('import.pensioners');
Route::get('/pensioners/bank', [PensionerController::class, 'showInvoiceBank'])->name('show.invoice.bank');
Route::get('/pensioners/invoice', [PensionerController::class, 'showSelectedBankPensionersForInvoiceGeneration'])->name('show.invoice');




Route::get('/pensioner/workflow', [PensionerworkflowController::class, 'showPensionerWorkflow'])->name('show.pensioner.workflow');
Route::post('/api/pensioner/workflow', [PensionerworkflowController::class, 'initiatePensionerWorkflow']);
Route::get('/api/pensioner/workflow/{id}', [PensionerworkflowController::class, 'isPensionerWorkflowExits']);



Route::get('/view/pensioners/pension/approved', [PensionController::class, 'showGenratePensionPage'])->name('show.approved.pensioner.section');
Route::get('/pension/generate', [PensionController::class, 'showGeneratePensionSection'])->name('show.generate.pension.section');
Route::get('/pensions/all', [PensionController::class, 'showAllGeneratedPensions'])->name('show.all.generated.pensions');
Route::post('/api/pensioners/pension/approved', [PensionController::class, 'calculatePensionAndInitiateWorkflow']);
Route::delete('/pension/{id}', [PensionController::class, 'deletePensionFromDB']);
Route::get('/pensions', [PensionController::class, 'showPensionsVariantSection'])->name('show.pensions.variant.section');
Route::get('/pension/dashboard/{id}', [PensionController::class, 'showPensionDashboard'])->name('show.pension.dashboard');
Route::get('/api/pension', [PensionController::class, 'isPensionExits']);
Route::get('/api/pension/isapproved', [PensionController::class, 'isPensionApproved']);
Route::get('/pension/export', [PensionController::class, 'exportPensionDashboard'])->name('download.pension');
Route::get('/pension/invoice/generate', [PensionController::class, 'generateInvoice'])->name('generate.invoice');




Route::get('/pension/workflow', [PensionworkflowController::class, 'showPensionWorkflow'])->name('show.pension.workflow');
Route::post('/api/pension/workflow', [PensionworkflowController::class, 'initiatePensionWorkflow']);
Route::get('/api/pension/workflow/{id}', [PensionworkflowController::class, 'isPensionWorkflowExits']);


Route::get('/officers', [OfficerController::class, 'getAllOfficersFromDB'])->name('show.officers');
Route::post('/officer', [OfficerController::class, 'registerOfficerIntoDB'])->name('registration.process');
Route::post('/officer/search', [OfficerController::class, 'getSpecificOfficerFromDB'])->name('get.specific.officers');
Route::post('/officer/update', [OfficerController::class, 'updateOfficerIntoDB'])->name('update.officer.process');
Route::post('/officer/remove', [OfficerController::class, 'removeOfficerFromDB'])->name('remove.officer.process');
Route::get('/officers/export', [OfficerController::class, 'exportOfficers'])->name('download.officers');
Route::get('/officers/export/template', [OfficerController::class, 'downloadOfficers'])->name('download.template.officers');
Route::get('/api/officer/pending', [OfficerController::class, 'getOfficerPendingTaskCount']);



Route::get('/offices', [OfficeController::class, 'getAllOfficesFromDB'])->name('show.offices');
Route::get('/paymentoffices', [OfficeController::class, 'getAllPaymentOfficesFromDB'])->name('show.payment.offices');
Route::get('/unitoffices', [OfficeController::class, 'getAllUnitOfficesFromDB'])->name('show.unit.offices');
Route::get('/search-offices', [OfficeController::class, 'search']);
Route::post('/office', [OfficeController::class, 'addOfficeIntoDB'])->name('add.office.process');
