<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
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




Route::resource('/sections', SectionsController::class);

Route::get('section/{id}', [InvoicesController::class, 'getProduct']);

Route::resource('/products', ProductsController::class);

Route::resource('/invoices', InvoicesController::class);

Route::get('/invoices-details/{id}', [InvoicesDetailsController::class,'index']);



require __DIR__ . '/auth.php';

Route::get('/{page}', [AdminController::class, 'index']);
