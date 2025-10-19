<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Pages
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', function () {
    return view('register');
})->name('register.page');

Route::get('/support', function () {
    return view('support');
})->name('support.page');

Route::get('/test', function () {
    return view('test');
})->name('test');

// Health check endpoint for Docker
Route::get('/health', function () {
    return response('healthy', 200)
        ->header('Content-Type', 'text/plain');
})->name('health');

// Registration Routes
Route::post('/register/submit', [RegistrationController::class, 'store'])->name('registration.submit');
Route::get('/registration/success/{registration}', [RegistrationController::class, 'success'])->name('registration.success');
Route::get('/registration/{registration}', [RegistrationController::class, 'show'])->name('registration.show');
Route::post('/registration/track', [RegistrationController::class, 'track'])->name('registration.track');

// Ticket Routes
Route::post('/support/ticket/submit', [TicketController::class, 'store'])->name('ticket.submit');
Route::post('/support/ticket/track', [TicketController::class, 'track'])->name('ticket.track');
Route::get('/ticket/{ticketNumber}', [TicketController::class, 'show'])->name('ticket.show');

// Admin Routes (No authentication for now - add authentication later)
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.main');

    // Tickets Management
    Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets');
    Route::get('/tickets/{id}', [AdminController::class, 'ticketShow'])->name('tickets.show');
    Route::post('/tickets/{id}/update', [AdminController::class, 'ticketUpdate'])->name('tickets.update');
    Route::delete('/tickets/{id}', [AdminController::class, 'ticketDestroy'])->name('tickets.destroy');
    Route::get('/tickets/export/csv', [AdminController::class, 'exportTickets'])->name('tickets.export');

    // Registrations Management
    Route::get('/registrations', [AdminController::class, 'registrations'])->name('registrations');
    Route::get('/registrations/{id}', [AdminController::class, 'registrationShow'])->name('registrations.show');
    Route::post('/registrations/{id}/update', [AdminController::class, 'registrationUpdate'])->name('registrations.update');
    Route::delete('/registrations/{id}', [AdminController::class, 'registrationDestroy'])->name('registrations.destroy');
    Route::get('/registrations/export/csv', [AdminController::class, 'exportRegistrations'])->name('registrations.export');
});
