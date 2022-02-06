<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
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

    Route::get('task/client/{client:username}', [ClientController::class, 'searchTaskByClient'])->name('searchTaskByClient');

    Route::resource('task', TaskController::class);

    Route::put('task/{task}/complete', [TaskController::class, 'markAsComplete'])->name('markAsComplete');

});

require __DIR__.'/auth.php';
