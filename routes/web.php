<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\InvoicesAttachmentController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {

    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');








Route::group(['middleware' => ['auth']], function () {

    Route::resource('/sections', SectionsController::class);

    Route::get('section/{id}', [InvoicesController::class, 'getProduct']);

    Route::resource('/products', ProductsController::class);

    Route::resource('/invoices', InvoicesController::class);

    Route::get('/edit_invoice/{id}', [InvoicesController::class, 'edit']);

    Route::resource('/InvoiceAttachments', InvoicesAttachmentController::class);

    Route::get('/invoices-details/{id}', [InvoicesDetailsController::class, 'index']);

    Route::get('/change_status/{id}', [InvoicesController::class, 'change_status'])->name('change_status');

    Route::post('/status_update/{id}', [InvoicesController::class, 'status_update'])->name('status_update');

    Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);

    Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);

    Route::post('/delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');



    Route::get('invoice_paid', [InvoicesController::class, 'invoice_paid'])->name('invoice_paid');

    Route::get('invoice_unpaid', [InvoicesController::class, 'invoice_unpaid'])->name('invoice_unpaid');

    Route::get('invoice_partial', [InvoicesController::class, 'invoice_partial'])->name('invoice_partial');

    Route::get('invoices_report', [Invoices_ReportController::class, 'invoices_report'])->name('invoices_report');

    Route::post('/search_invoices', [Invoices_ReportController::class, 'search_invoices']);

    Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice'])->name('Print_invoice');

    Route::resource('archive_invoices', InvoiceAchiveController::class);

    Route::get('export_invoices', [InvoicesController::class, 'export']);

    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

});



require __DIR__ . '/auth.php';

Route::get('/{page}', [AdminController::class, 'index']);
