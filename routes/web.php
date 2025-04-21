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
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index')->name('users.index')->middleware('permission.action:User Management,viewAny');
        Route::get('/create', 'create')->name('users.create')->middleware('permission.action:User Management,create');
        Route::post('/create', 'store')->name('users.store')->middleware('permission.action:User Management,create');
        Route::get('/{id}', 'show')->name('users.show')->middleware('permission.action:User Management,view');
        Route::get('/{id}/edit', 'edit')->name('users.edit')->middleware('permission.action:User Management,update');
        Route::put('/{id}', 'update')->name('users.update')->middleware('permission.action:User Management,update');
        Route::delete('/{id}', 'delete')->name('users.delete')->middleware('permission.action:User Management,delete');
    });

    Route::controller(ProjectController::class)->prefix('projects')->group(function () {
        Route::get('/', 'index')->name('projects.index')->middleware('permission.action:Project Management,viewAny');
        Route::get('/department', 'list')->name('projects.list')->middleware('permission.action:Project Management,viewAny');
        Route::get('/create', 'create')->name('projects.create')->middleware('permission.action:Project Management,create');
        Route::post('/create', 'store')->name('projects.store')->middleware('permission.action:Project Management,create');
        Route::get('/{id}', 'show')->name('projects.show')->middleware('permission.action:Project Management,view');
        Route::get('/{id}/edit', 'edit')->name('projects.edit')->middleware('permission.action:Project Management,update');
        Route::put('/{id}', 'update')->name('projects.update')->middleware('permission.action:Project Management,update');
        Route::delete('/{id}', 'delete')->name('projects.delete')->middleware('permission.action:Project Management,delete');
    });

    Route::controller(TaskController::class)->prefix('tasks')->group(function () {
        Route::get('/', 'index')->name('tasks.index')->middleware('permission.action:Task Management,viewAny');
        Route::get('/created-by', 'list')->name('tasks.list')->middleware('permission.action:Task Management,viewAny');
        Route::get('/create', 'create')->name('tasks.create')->middleware('permission.action:Task Management,create');
        Route::post('/create', 'store')->name('tasks.store')->middleware('permission.action:Task Management,create');
        Route::get('/{id}/update', 'edit')->name('tasks.edit')->middleware('permission.action:Task Management,update');
        Route::get('/{id}', 'show')->name('tasks.show')->middleware('permission.action:Task Management,view');
        Route::put('/{id}', 'update')->name('tasks.update')->middleware('permission.action:Task Management,update');
        Route::delete('/{id}', 'delete')->name('tasks.delete')->middleware('permission.action:Task Management,delete');
    });

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index')->middleware('permission.action:Role Management,viewAny');
        Route::get('/create', 'create')->name('roles.create')->middleware('permission.action:Role Management,create');
        Route::post('/create', 'store')->name('roles.store')->middleware('permission.action:Role Management,create');
        Route::get('/{id}', 'show')->name('roles.show')->middleware('permission.action:Role Management,update');
        Route::put('/{id}', 'update')->name('roles.update')->middleware('permission.action:Role Management,update');
        Route::delete('/{id}', 'delete')->name('roles.delete')->middleware('permission.action:Role Management,delete');
    });

    Route::controller(ActionController::class)->prefix('actions')->group(function () {
        Route::get('/', 'index')->name('actions.index')->middleware('permission.action:Action Management,viewAny');
        Route::get('/create', 'create')->name('actions.create')->middleware('permission.action:Action Management,create');
        Route::post('/create', 'store')->name('actions.store')->middleware('permission.action:Action Management,create');
        Route::get('/{id}', 'show')->name('actions.show')->middleware('permission.action:Action Management,update');
        Route::put('/{id}', 'update')->name('actions.update')->middleware('permission.action:Action Management,update');
        Route::delete('/{id}', 'delete')->name('actions.delete')->middleware('permission.action:Action Management,delete');
    });

    Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
        Route::get('/', 'index')->name('permissions.index')->middleware('permission.action:Permission Management,viewAny');
        Route::get('/create', 'create')->name('permissions.create')->middleware('permission.action:Permission Management,create');
        Route::post('/create', 'store')->name('permissions.store')->middleware('permission.action:Permission Management,create');
        Route::get('/{id}', 'show')->name('permissions.show')->middleware('permission.action:Permission Management,update');
        Route::put('/{id}', 'update')->name('permissions.update')->middleware('permission.action:Permission Management,update');
        Route::delete('/{id}', 'delete')->name('permissions.delete')->middleware('permission.action:Permission Management,delete');
    });

    Route::controller(PositionController::class)->prefix('positions')->group(function () {
        Route::get('/', 'index')->name('positions.index')->middleware('permission.action:Position Management,viewAny');
        Route::get('/create', 'create')->name('positions.create')->middleware('permission.action:Position Management,create');
        Route::post('/create', 'store')->name('positions.store')->middleware('permission.action:Position Management,create');
        Route::get('/{id}', 'show')->name('positions.show')->middleware('permission.action:Position Management,update');
        Route::put('/{id}', 'update')->name('positions.update')->middleware('permission.action:Position Management,update');
        Route::delete('/{id}', 'delete')->name('positions.delete')->middleware('permission.action:Position Management,delete');
    });

    Route::controller(DepartmentController::class)->prefix('departments')->group(function () {
        Route::get('/', 'index')->name('departments.index')->middleware('permission.action:Department Management,viewAny');
        Route::get('/create', 'create')->name('departments.create')->middleware('permission.action:Department Management,create');
        Route::post('/create', 'store')->name('departments.store')->middleware('permission.action:Department Management,create');
        Route::get('/{id}', 'show')->name('departments.show')->middleware('permission.action:Department Management,update');
        Route::put('/{id}', 'update')->name('departments.update')->middleware('permission.action:Department Management,update');
        Route::delete('/{id}', 'delete')->name('departments.delete')->middleware('permission.action:Department Management,delete');
    });
});

Route::fallback(function () {
    return view('errors.404');
});