<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group.
|
*/

// Public API Routes
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

// Protected API Routes (Require Authentication)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // User Profile
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('profile', [AuthController::class, 'updateProfile']);
    Route::put('password', [AuthController::class, 'updatePassword']);
    
    // User Management (Admin Only)
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::apiResource('users', UserController::class);
        Route::get('users/{user}/roles', [UserController::class, 'roles'])->name('users.roles');
        Route::post('users/{user}/roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
        Route::delete('users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.remove-role');
    });
    
    // Role Management (Admin Only)
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::post('roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('roles.sync-permissions');
    });
    
    // Tenant Management (Admin & Users with manage tenants permission)
    Route::middleware(['permission:manage tenants|manage tenants'])->group(function () {
        Route::apiResource('tenants', TenantController::class);
        Route::get('tenants/{tenant}/users', [TenantController::class, 'users'])->name('tenants.users');
    });
});
