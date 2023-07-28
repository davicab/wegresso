<?php

use App\Http\Controllers\CursosController;
use App\Http\Controllers\GraficosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [HomeController::class, 'index']);

Route::get('/{curso}', [CursosController::class, 'index']);

Route::get('/cursos/graficos', [GraficosController:: class, 'index']);

Route::get('/register', function () {
    return redirect()->to(config('app.url').'/', 301);
});
Route::get('/logout', function () {
    return redirect()->to(config('app.url').'/', 301);
});