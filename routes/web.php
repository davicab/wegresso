<?php

use App\Http\Controllers\CursosController;
use App\Http\Controllers\EditarAlunoController;
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

// Rotas de autenticação
Auth::routes();

// Rota para o painel de administração
Route::get('/painel-administracao', [VerifyDataController::class, 'index']);

// Rota para editar dados de um aluno
Route::get('/editar-aluno/{id}', [EditarAlunoController::class, 'index']);

// Rota para salvar a edição dos dados de um aluno
Route::put('/edita-dados/{id}', [EditarAlunoController::class, 'editaDados']);

// Rota para visualizar e validar os dados de um usuário (administrador)
Route::get('/validar-egresso/{id}', [VerifyDataController::class, 'userVerfiyView']);

// Rota para validar dados de um usuário (administrador)
Route::put('/validar-dados/{id}', [VerifyDataController::class, 'validarDados']);

// Rota para criar um curso (administrador)
Route::put('/create-curso', [VerifyDataController::class, 'createCurso']);

// Rota para o perfil do usuário
Route::get('/perfil', [PerfilController::class, 'index']);

// Rota para salvar o perfil do usuário
Route::put('/salvar-perfil/{id}', [PerfilController::class, 'salvarPerfil']);

// Rota inicial
Route::get('/', [HomeController::class, 'index']);

// Rota para listar todos os cursos
Route::get('/cursos', [CursosController::class, 'index']);

// Rota para exibir informações de um curso específico
Route::get('/cursos/{slug}/{codigo}', [CursosController::class, 'singleCurso']);

// Rota para exibir gráficos de cursos
Route::get('/cursos/graficos', [GraficosController::class, 'index']);

// Redirecionamento da rota /register
Route::get('/register', function () {
    return redirect()->to(config('app.url') . '/register', 301);
});

// Redirecionamento da rota /logout
Route::get('/logout', function () {
    return redirect()->to(config('app.url') . '/', 301);
});

// Rota para receber e processar um arquivo CSV
Route::put('/receive-csv', [VerifyDataController::class, 'convertData']);