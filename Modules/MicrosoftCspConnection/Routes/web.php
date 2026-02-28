<?php

use Illuminate\Support\Facades\Route;
use Modules\MicrosoftCspConnection\Http\Controllers\MicrosoftCspController;

/*
|--------------------------------------------------------------------------
| Web Routes — MicrosoftCspConnection Module
|--------------------------------------------------------------------------
*/

Route::prefix('microsoft-csp')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [MicrosoftCspController::class, 'index'])->name('microsoft-csp.index');
    Route::get('/test', [MicrosoftCspController::class, 'test'])->name('microsoft-csp.test');
});
