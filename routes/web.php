<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/*
 Web Routes
*/

// Front-end

Route::get('/', function () {
    return view('welcome');
});



// Back-end





Route::prefix('dashboard')->middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('client', ClientController::class);

});

require __DIR__.'/auth.php';
