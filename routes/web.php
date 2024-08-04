<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\User\ClientController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\Client\InvoiceClientController;
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
Route::middleware(['auth:superAdmin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
});

// Routes for users
Route::middleware(['auth:web'])->group(function () {
    Route::prefix('invoices')->group(function () {
        Route::get('/all', [InvoiceController::class, 'all'])->name('invoices.all');
        Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/{id}/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    });

    Route::prefix('clients')->group(function () {
        Route::get('/all', [ClientController::class, 'all'])->name('clients.all');
        Route::get('/{id}/showInvoices', [ClientController::class, 'showInvoices'])->name('clients.showInvoices');
        Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::get('/download', [ClientController::class, 'download'])->name('clients.download');
        Route::post('/', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/{id}', [ClientController::class, 'show'])->name('clients.show');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    });
});

// Routes for clients
Route::middleware(['auth:client'])->group(function () {
    Route::prefix('client/invoices')->group(function () {
        Route::get('/', [InvoiceClientController::class, 'index'])->name('client.invoices.index');
        Route::get('/{id}', [InvoiceClientController::class, 'show'])->name('client.invoices.show');
    });
});
