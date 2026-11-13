<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    if (!session('usuario_id')) {
        return redirect('/login');
    }

    return view('crear_ticket');
});

Route::post('/guardar-tickets', [TicketController::class, 'store'])->name('tickets.store');

Route::get('/panel', [TicketController::class, 'index'])->name('tickets.index');

Route::post('/ticket/{id}/estado', [TicketController::class, 'actualizarEstado'])->name('tickets.estado');

Route::get('/ticket/{id}', [TicketController::class, 'show'])->name('tickets.show');
