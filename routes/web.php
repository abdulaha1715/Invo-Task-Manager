<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TaskController;
use App\Mail\InvoiceEmail;
use Illuminate\Support\Facades\Route;

/*
 Web Routes
*/

// Front-end

Route::get('/', function () {
    return view('welcome');
});


// Back-end
Route::prefix('/')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Client Route
    Route::resource('client', ClientController::class);

    // Task by Client
    Route::get('client/{client:username}', [ClientController::class, 'searchTaskByClient'])->name('searchTaskByClient');

    // Task Route
    Route::resource('task', TaskController::class);

    // invocies Route
    Route::put('task/{task}/complete', [TaskController::class, 'markAsComplete'])->name('markAsComplete');

    // Invocies Route
    Route::prefix('invoice')->group(function() {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('create', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::put('{invoice}/update', [InvoiceController::class, 'update'])->name('invoice.update');
        Route::get('preview', [InvoiceController::class, 'preview'])->name('preview.invoice');
        Route::get('generate', [InvoiceController::class, 'generate'])->name('invoice.generate');
        Route::delete('{invoice}/delete', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
        Route::get('email-send/{invoice:invoice_id}', [InvoiceController::class, 'sendEmail'])->name('invoice.sendemail');
    });

    // Route::get('/email', function () {

    //     $data = [
    //         'user'       => '',
    //         'invoice_id' => '',
    //         'invoice'    => '',
    //         'pdf'        => ''
    //     ];

    //     return new InvoiceEmail($data);
    // });


});

require __DIR__.'/auth.php';
