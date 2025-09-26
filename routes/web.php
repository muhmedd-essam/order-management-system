<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View\CustomerController;
use App\Http\Controllers\View\DashboardController;
use App\Http\Controllers\View\OrderController;
use App\Http\Controllers\View\ProductController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customers listing accessible to authenticated users (staff and admin)
    Route::get('/customers', [CustomerController::class, 'findByEmailOrName'])->name('customers.index');
    // Products listing accessible to authenticated users (staff and admin)

    Route::get('products', [ProductController::class, 'index'])->name('products.index');

    // Orders listing accessible to authenticated users (staff and admin)

    Route::resource('orders', OrderController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-only CRUD except index which is open to staff as well
    Route::resource('customers', CustomerController::class)->except(['index', 'show']);
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');




});


require __DIR__.'/auth.php';
