<?php

use App\Http\Controllers\Web\ActionController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DepartmentController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\PositionController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\SubtaskController;
use App\Http\Controllers\Web\TaskController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::controller(AuthController::class)->middleware('guest')->prefix('/')->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/', 'handleLogin')->name('action.login');
});


Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index')->name('users.index');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/create', 'store')->name('users.store');
        Route::get('/{id}', 'show')->name('users.show');
        Route::put('/{id}', 'update')->name('users.update');
        Route::delete('/{id}', 'delete')->name('users.delete');
    });

    Route::controller(ProjectController::class)->prefix('projects')->group(function () {
        Route::get('/', 'index')->name('projects.index');
        Route::get('/create', 'create')->name('projects.create');
        Route::post('/create', 'store')->name('projects.store');
        Route::get('/{id}', 'show')->name('projects.show');
        Route::put('/{id}', 'update')->name('projects.update');
        Route::delete('/{id}', 'delete')->name('projects.delete');
    });

    Route::controller(TaskController::class)->prefix('tasks')->group(function () {
        Route::get('/', 'index')->name('tasks.index');
        Route::get('/create', 'create')->name('tasks.create');
        Route::post('/create', 'store')->name('tasks.store');
        Route::get('/{id}/update', 'edit')->name('tasks.edit');
        Route::get('/{id}', 'show')->name('tasks.show');
        Route::put('/{id}', 'update')->name('tasks.update');
        Route::delete('/{id}', 'delete')->name('tasks.delete');
    });

    Route::controller(SubtaskController::class)->prefix('subtasks')->group(function () {
        Route::get('/', 'index')->name('subtasks.index');
        Route::get('/create', 'create')->name('subtasks.create');
        Route::post('/create', 'store')->name('subtasks.store');
        Route::get('/{id}', 'show')->name('subtasks.show');
        Route::put('/{id}', 'update')->name('subtasks.update');
        Route::delete('/{id}', 'delete')->name('subtasks.delete');
    });

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index');
        Route::get('/create', 'create')->name('roles.create');
        Route::post('/create', 'store')->name('roles.store');
        Route::get('/{id}', 'show')->name('roles.show');
        Route::put('/{id}', 'update')->name('roles.update');
        Route::delete('/{id}', 'delete')->name('roles.delete');
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

    Route::controller(PositionController::class)->prefix('positions')->group(function () {
        Route::get('/', 'index')->name('positions.index');
        Route::get('/create', 'create')->name('positions.create');
        Route::post('/create', 'store')->name('positions.store');
        Route::get('/{id}', 'show')->name('positions.show');
        Route::put('/{id}', 'update')->name('positions.update');
        Route::delete('/{id}', 'delete')->name('positions.delete');
    });

    Route::controller(DepartmentController::class)->prefix('departments')->group(function () {
        Route::get('/', 'index')->name('departments.index');
        Route::get('/create', 'create')->name('departments.create');
        Route::post('/create', 'store')->name('departments.store');
        Route::get('/{id}', 'show')->name('departments.show');
        Route::put('/{id}', 'update')->name('departments.update');
        Route::delete('/{id}', 'delete')->name('departments.delete');
    });
});

Route::fallback(function () {
    return view('errors.404');
});