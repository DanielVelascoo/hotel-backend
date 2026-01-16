<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/test-auth', function () {
    return response()->json(Auth::user());
})->middleware('auth.token');

Route::get('/solo-admin', function () {
    return 'ACCESO ADMIN OK';
})->middleware(['auth.token', 'rol:admin']);
