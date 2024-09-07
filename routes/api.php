<?php

use App\Http\Controllers\AlunoRegistro;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//AUTH CONTROLLER
Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::get('unauthorized',  'unauthorized')->name('login');//erro de nao autorizado pro sanctum
});

//rotas que necessitam o usuario estar autenticado
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);

    //Cadastro aluno
    Route::post('/cadastrarAluno', [AlunoRegistro::class, 'cadastrarAcademico']);
    Route::get('/consultaAluno', [AlunoRegistro::class, 'getAluno']);
});






