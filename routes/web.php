<?php

use Illuminate\Support\Facades\Route;

Route::get('/jogadores', function () {
    return view('cadastrar-jogadores');
});
