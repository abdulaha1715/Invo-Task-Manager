<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $user = User::find(Auth::user()->id);
        return view('dashboard')->with([
            'user'            => $user,
            'activity_logs'   => ActivityLog::where('user_id', Auth::id())->latest()->get(),
            'pending_tasks'   => $user->tasks->where('status', 'pending'),
            'paid_invoices'   => $user->invoices->where('status', 'paid'),
            'unpaid_invoices' => $user->invoices->where('status', 'unpaid'),
        ]);
    })->name('dashboard');

    // Users Route
    Route::resource('users', UserController::class);

    // Client Route
    Route::resource('client', ClientController::class);

    // Task Route
    Route::resource('task', TaskController::class);
    Route::put('task/{task}/complete', [TaskController::class, 'markAsComplete'])->name('markAsComplete');

    // Invocies Route
    Route::prefix('invoices')->group(function() {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('create', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::put('{invoice}/update', [InvoiceController::class, 'update'])->name('invoice.update');
        Route::get('invoice', [InvoiceController::class, 'invoice'])->name('invoice');
        Route::delete('{invoice}/delete', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
        Route::get('email-send/{invoice:invoice_id}', [InvoiceController::class, 'sendEmail'])->name('invoice.sendemail');
    });

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/update', [SettingsController::class, 'update'])->name('settings.update');


});

require __DIR__.'/auth.php';
