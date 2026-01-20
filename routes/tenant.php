<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\CheckTenantForMaintenanceMode;
use App\Http\Controllers\Tenant\Auth\TenantLoginController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,   // REQUIRED
    PreventAccessFromCentralDomains::class,
    // CheckTenantForMaintenanceMode::class,
])->name('tenant.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('tenant.login');
    })->middleware('guest');
    Route::get('/login', [TenantLoginController::class, 'show'])->name('login')->middleware('guest');
    Route::post('/login', [TenantLoginController::class, 'store'])->name('login.store');
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout(); // log out tenant user

        $request->session()->invalidate(); // clear session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect()->route('tenant.login'); // redirect to tenant login
    })->name('logout');
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', fn () => Inertia::render('Tenant/Dashboard'))
            ->name('dashboard');
    });
});