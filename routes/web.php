<?php

use App\Http\Controllers\Web\ActionController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\RoleController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->middleware('guest')->prefix('/')->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/', 'handleLogin')->name('action.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index');
        // Route::get('/create', 'create')->name('roles.create');
        // Route::post('/', 'store')->name('roles.store');
        // Route::get('/{role}', 'show')->name('roles.show');
        // Route::get('/{role}/edit', 'edit')->name('roles.edit');
        // Route::put('/{role}', 'update')->name('roles.update');
        // Route::delete('/{role}', 'destroy')->name('roles.destroy');
    });

    Route::controller(ActionController::class)->prefix('actions')->group(function () {
        Route::get('/', 'index')->name('actions.index');
        Route::get('/create', 'create')->name('actions.create');
        Route::post('/create', 'store')->name('actions.store');
        Route::get('/{id}', 'show')->name('actions.show');
        Route::put('/{id}', 'update')->name('actions.update');
        Route::delete('/{id}', 'delete')->name('actions.delete');
    });

    Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
        Route::get('/', 'index')->name('permissions.index');
        Route::get('/create', 'create')->name('permissions.create');
        Route::post('/create', 'store')->name('permissions.store');
        Route::get('/{id}', 'show')->name('permissions.show');
        Route::put('/{id}', 'update')->name('permissions.update');
        Route::delete('/{id}', 'delete')->name('permissions.delete');
    });
});