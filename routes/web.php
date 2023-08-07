<?php

use App\Http\Controllers\CursosController;
use App\Http\Controllers\GraficosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\VerifyDataController;
use App\Http\Middleware\Authenticate;
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

Route::get('/painel-administracao', [VerifyDataController:: class, 'index']);

Route::put('/import-data', [VerifyDataController:: class, 'importData']);

Route::get('/validar-egresso/{id}', [VerifyDataController:: class, 'userVerfiyView']);

Route::put('/validar-dados/{id}', [VerifyDataController:: class, 'validarDados']);

Route::put('/create-curso', [VerifyDataController:: class, 'createCurso']);

Route::get('/perfil', [PerfilController:: class, 'index']);

Route::put('/salvar-perfil/{id}', [PerfilController:: class, 'salvarPerfil']);

Route::get('/', [HomeController::class, 'index']);

Route::get('/cursos', [CursosController::class, 'index']);

Route::get('/cursos/{slug}/{codigo}', [CursosController:: class, 'singleCurso']);

Route::get('/cursos/graficos', [GraficosController:: class, 'index']);

Route::get('/register', function () {
    return redirect()->to(config('app.url').'/', 301);
});
Route::get('/logout', function () {
    return redirect()->to(config('app.url').'/', 301);
});
