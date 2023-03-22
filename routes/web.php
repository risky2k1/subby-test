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

        Route::post('/subscribe', function (Illuminate\Http\Request $request) {
            $company = App\Models\Company::find($request->input('company_id'));

            $plan = Plan::find($request->input('plan'));
//    dd($plan->description);
            // Subscribe the company to the selected plan
//            if ($plan === '6-months') {
////                dd('vao day');
                $company->newSubscription(
                    'main', // identifier tag of the subscription. If your application offers a single subscription, you might call this 'main' or 'primary'
                    $plan, // Plan or PlanCombination instance your subscriber is subscribing to
                    $plan->name, // Human-readable name for your subscription
                    $plan->description, // Description
                    null, // Start date for the subscription, defaults to now()
                    'free' // Payment method service defined in config
                );
//                dd('plan sub succsses');
//            } elseif ($plan === '12-months') {
//                $company->newSubscription('main', '12-months')->create();
//            }

            return redirect()->route('index')->with('success', 'Your subscription has been created.');
        })->name('subscribe');
    });

});
