<?php

use App\Http\Controllers\ProfileController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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

Route::get('/invoice-mail', function () {
    $invoice = Invoice::first();
    return view('emails.invoice', compact('invoice'));
});

Route::get('/dashboard', [UserController::class, 'indexCourseRegistration'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/course', [UserController::class, 'index'])->name('course.index');
    Route::get('/register-course', [UserController::class, 'registerForm'])->name('course.register');
    Route::post('/register-course', [UserController::class, 'store'])->name('course.store');

    Route::get('/invoice', [UserController::class, 'invoice'])->name('course.invoice');
    Route::post('/checkout/{id?}', [UserController::class, 'checkout'])->name('invoice.checkout');
    Route::get('/payment/success', [UserController::class, 'success'])->name('payment.success');

    Route::get('/course-registration/{id?}', [UserController::class, 'viewRegistration'])->name('course-registration.view');
});

require __DIR__.'/auth.php';
