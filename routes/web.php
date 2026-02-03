<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('admin.login'),
        'canRegister' => Route::has('admin.register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/admin/login', function () {
    return Inertia::render('Auth/Login');
})->name('admin.login')->middleware('guest');

Route::get('/admin/register', function () {
    return Inertia::render('Auth/Register');
})->name('admin.register')->middleware('guest');

Route::post('/admin/register', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    Auth::login($user);

    return redirect()->route('dashboard');
})->name('admin.register.store')->middleware('guest');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (! \Auth::attempt($credentials)) {
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    $request->session()->regenerate();

    return redirect()->route('dashboard');
})->name('admin.login.store');

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout(); // log out tenant user

    $request->session()->invalidate(); // clear session
    $request->session()->regenerateToken(); // regenerate CSRF token

    return redirect()->route('admin.login');
})->name('admin.logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    Route::resource('/domains', DomainController::class);
    Route::prefix('admin')->name('admin.')
        ->group(function () {
            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);
        });
});
