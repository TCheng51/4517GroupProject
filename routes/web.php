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
Route::post('/register', [RegisterController::class, 'processRegistration'])
    ->middleware('throttle:6,1')
    ->name('register.store');
Route::get('/register/confirm', [RegisterController::class, 'showConfirmationForm'])->name('register.confirm');
Route::post('/register/confirm', [RegisterController::class, 'confirmRegistration'])
    ->middleware('throttle:6,1')
    ->name('register.confirm.submit');
Route::get('/register/success', [RegisterController::class, 'showSuccessPage'])->name('register.success');

// AJAX endpoints — throttled to mitigate enumeration/abuse.
Route::post('/api/register', [RegisterController::class, 'ajaxRegister'])
    ->middleware('throttle:10,1')
    ->name('register.ajax');
Route::post('/api/check-email', [RegisterController::class, 'checkEmailAvailability'])
    ->middleware('throttle:5,1')
    ->name('register.check-email');
Route::post('/api/validate-registration', [RegisterController::class, 'validateRegistration'])
    ->middleware('throttle:10,1')
    ->name('register.validate');

Route::get('/login', [MemberController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MemberController::class, 'login'])
    ->middleware('throttle:6,1')
    ->name('login.submit');

Route::get('/reservation', [MemberController::class, 'showReservation'])->name('reservation');
Route::get('/reservation/confirm', [MemberController::class, 'confirmReservation'])->name('reservation.confirm');
Route::post('/reservation', [MemberController::class, 'makeReservation'])
    ->middleware('throttle:10,1')
    ->name('reservation.submit');
Route::get('/reservation/success', [MemberController::class, 'reservationSuccess'])->name('reservation.success');

Route::post('/logout', [MemberController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/menu', [MemberController::class, 'showMenu'])->name('menu');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/room-status', [MemberController::class, 'showRoomStatus'])->name('room-status');
    Route::post('/room-status/{reservation}', [MemberController::class, 'updateRoomStatus'])->name('room-status.update');
});

Route::get('/thankyou', function () {
    return view('thankyou');
})->name('thankyou');
