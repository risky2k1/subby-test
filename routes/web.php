<?php

use Bpuig\Subby\Models\Plan;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user-login', function () {
    return view('auth.login');
});
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
], function () {
    Route::group([
        'as' => 'company.',
        'prefix' => 'company',
    ], function () {
        Route::get('/', [\App\Http\Controllers\CompanyController::class, 'index'])->name('index');

        Route::post('/subscribe', [\App\Http\Controllers\CompanyController::class,'subscribeCompany'])->name('subscribe');
    });

});
