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

Route::get('/login', [MemberController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MemberController::class, 'login'])
    ->middleware('throttle:6,1')
    ->name('login.submit');

Route::get('/menu', [MemberController::class, 'showMenu'])->name('menu');
Route::get('/reservation', [MemberController::class, 'showReservation'])->name('reservation');
Route::get('/reservation/confirm', [MemberController::class, 'confirmReservation'])->name('reservation.confirm');
Route::post('/reservation', [MemberController::class, 'makeReservation'])
    ->middleware('throttle:10,1')
    ->name('reservation.submit');
Route::get('/reservation/success', [MemberController::class, 'reservationSuccess'])->name('reservation.success');

Route::post('/logout', [MemberController::class, 'logout'])->name('logout');

Route::get('/room-status', [MemberController::class, 'showRoomStatus'])
    ->middleware('auth')
    ->name('room-status');
Route::post('/room-status/{reservation}', [MemberController::class, 'updateRoomStatus'])
    ->middleware('auth')
    ->name('room-status.update');

Route::get('/my-reservations', [MemberController::class, 'myReservations'])
    ->middleware('auth')
    ->name('my-reservations');
Route::get('/my-reservations/{reservation}/edit', [MemberController::class, 'editReservation'])
    ->middleware('auth')
    ->name('my-reservations.edit');
Route::patch('/my-reservations/{reservation}', [MemberController::class, 'updateReservation'])
    ->middleware('auth')
    ->name('my-reservations.update');
Route::post('/my-reservations/{reservation}/cancel', [MemberController::class, 'cancelReservation'])
    ->middleware('auth')
    ->name('my-reservations.cancel');

Route::get('/reservation/availability', [MemberController::class, 'availability'])
    ->name('reservation.availability');

Route::get('/thankyou', function () {
    return view('thankyou');
})->name('thankyou');

Route::get('/reservation-history', [MemberController::class, 'reservationHistory'])
    ->middleware('auth:web')
    ->name('reservation-history');
