<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
	Route::get('/login', [AuthController::class, 'create'])->name('login');
	Route::post('/login', [AuthController::class, 'store'])->name('login.store');
	Route::get('/register', [AuthController::class, 'createRegistration'])->name('register');
	Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
	->middleware('auth')
	->name('logout');

Route::middleware('auth')->group(function () {
	Route::get('/', [TaskController::class, 'index']);
	Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
	Route::resource('tasks', TaskController::class);
});
