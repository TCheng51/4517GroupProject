<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegisterController;

Route::get('/', [MemberController::class, 'home'])->name('index');
Route::redirect('/home', '/')->name('home');
Route::redirect('/frontend', '/');
Route::redirect('/frontend/index.html', '/');
Route::redirect('/frontend/register.html', '/register');
Route::redirect('/frontend/login.html', '/login');
Route::redirect('/frontend/reservation.html', '/reservation');
Route::redirect('/frontend/thankyou.html', '/thankyou');
Route::redirect('/frontend/login.php', '/login');
Route::redirect('/frontend/reserve.php', '/reservation');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'processRegistration'])->name('register.store');
Route::get('/register/confirm', [RegisterController::class, 'showConfirmationForm'])->name('register.confirm');
Route::post('/register/confirm', [RegisterController::class, 'confirmRegistration'])->name('register.confirm.submit');
Route::get('/register/success', [RegisterController::class, 'showSuccessPage'])->name('register.success');

// AJAX routes for registration
Route::post('/api/register', [RegisterController::class, 'ajaxRegister'])->name('register.ajax');
Route::post('/api/check-email', [RegisterController::class, 'checkEmailAvailability'])->name('register.check-email');
Route::post('/api/validate-registration', [RegisterController::class, 'validateRegistration'])->name('register.validate');

Route::get('/login', [MemberController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MemberController::class, 'login'])->name('login.submit');

Route::get('/reservation', [MemberController::class, 'showReservation'])->name('reservation');
Route::get('/reservation/confirm', [MemberController::class, 'confirmReservation'])->name('reservation.confirm');
Route::post('/reservation', [MemberController::class, 'makeReservation'])->name('reservation.submit');
Route::get('/reservation/success', [MemberController::class, 'reservationSuccess'])->name('reservation.success');

Route::post('/logout', [MemberController::class, 'logout'])->name('logout');

Route::get('/thankyou', function () {
    return view('thankyou');
})->name('thankyou');
