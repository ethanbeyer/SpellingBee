<?php

use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // @todo -- ask for letters
});

// Main Route
Route::get('/words/{letters}', [WordController::class, 'find_words']);
