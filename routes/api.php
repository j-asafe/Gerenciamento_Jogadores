<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\JogadoresController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/Jogadores', [JogadoresController::class, 'index']);
Route::post('/criarJogadores', [JogadoresController::class, 'store']);
Route::get('/Jogadores/{id}', [JogadorController::class, 'edit']);
Route::put('/upJogadores/{id}', [JogadoresController::class, 'update']);
Route::delete('/deljogadores/{id}', [JogadoresController::class, 'destroy']);
