<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\User\InvoiceClientController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('register', function() {
    return view('auth.register');
})->name('register');

Route::post('register', [AuthController::class, 'register']);

Route::get('login', function() {
    return view('auth.login');
})->name('login');

Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

// Routes for admins
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    // Route::resource('clients', ClientController::class);
    // Route::resource('invoices', InvoiceController::class);

    // OR
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/', [ClientController::class, 'store'])->name('store');
        Route::get('/{id}', [ClientController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClientController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
    });
});

// Routes for users
Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceClientController::class, 'index'])->name('index');
        Route::get('invoices/{id}', [InvoiceClientController::class, 'show'])->name('show');
    });

});


