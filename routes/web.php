<?php

use App\Models\News;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Cargo;
use App\Models\Company;
use App\Models\Transport;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\ApplicationsController;

Route::get('/', function () {
    return redirect()->route('profile');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/privacy', function () {
    return Inertia::render('PrivacyView');
})->name('privacy');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('ApplicationsView');
    })->name('dashboard');

    Route::get('/profile', function () {
        return Inertia::render('ProfileView', [
            'auth' => [
                'user' => auth()->user()->load('company'),
            ],
        ]);
    })->name('profile');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/add-employee', [ProfileController::class, 'addEmployee'])->name('add.employee');
    Route::put('/applications/{application}', [ApplicationsController::class, 'update']);

    Route::get('/applications', function () {
        return Inertia::render('ApplicationsView', [
            'auth' => [
                'user' => Auth::user(),
            ],
            'applications' => Application::with('company')->get(),
        ]);
    })->name('applications');

    Route::post('/applications/from-cargo', [ApplicationsController::class, 'storeFromCargo'])
    ->name('applications.store.fromCargo');
    
    Route::get('/cargos', function () {
        return Inertia::render('CargosView', [
            'auth' => [
                'user' => auth()->user()->load('company'),
            ],
            'cargos' => Cargo::with('company')->get(),
        ]);
    })->name('cargos');

    Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store');

    Route::get('/companies', function () {
        return Inertia::render('CompaniesView', [
            'auth' => [
                'user' => Auth::user(),
            ],
            'companies' => Company::get(),
        ]);
    })->name('companies');

    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');

    Route::get('/my-company', function () {
        return Inertia::render('MyCompanyView', [
            'auth' => [
                'user' => Auth::user()->load(['company.cargos']),
            ],
            'users' => Auth::user()?->company?->users,
            'unassignedUsers' => User::whereNull('company_id')->get(),
        ]);
    })->name('my.company');

    Route::get('/news', function () {
        return Inertia::render('NewsView', [
            'auth' => [
                'user' => Auth::user(),
            ],
            'news' => News::get(),
        ]);
    })->name('news');

    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    Route::get('/transport', function () {
        return Inertia::render('TransportView', [
            'auth' => [
                'user' => Auth::user(),
            ],
            'transports' => Transport::get(),
        ]);
    })->name('transport');

    Route::delete('/transport/{id}', [TransportController::class, 'destroy'])->name('transport.destroy');

    Route::get('/users', function () {
        return Inertia::render('UsersView', [
            'auth' => [
                'user' => Auth::user(),
            ],
            'users' => User::with('company')->get(),
        ]);
    })->name('users');

    Route::post('/transport', [TransportController::class, 'store'])->name('transport.store');

    Route::post('/users/{id}/block', [UserController::class, 'block'])->name('users.block');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
});