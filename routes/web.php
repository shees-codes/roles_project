<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\TenantController as AdminTenantController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Guest Routes (Unauthenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Authentication
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Registration
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    
    // Reset Password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationPromptController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    // Confirm Password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
    // Update Password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Dashboard (requires email verification)
    Route::middleware(['verified'])->group(function () {
        Route::get('dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        
        // Profile Management
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Admin Routes (Requires Super Admin Role)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
            // Dashboard
            Route::get('dashboard', function () {
                return view('dashboard');
            })->name('dashboard');
            
            // User Management
            Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
            Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
            Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
            Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
            Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
            Route::patch('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
            Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
            
            // Role Management
            Route::get('roles', [AdminRoleController::class, 'index'])->name('roles.index');
            Route::get('roles/create', [AdminRoleController::class, 'create'])->name('roles.create');
            Route::post('roles', [AdminRoleController::class, 'store'])->name('roles.store');
            Route::get('roles/{role}', [AdminRoleController::class, 'show'])->name('roles.show');
            Route::get('roles/{role}/edit', [AdminRoleController::class, 'edit'])->name('roles.edit');
            Route::patch('roles/{role}', [AdminRoleController::class, 'update'])->name('roles.update');
            Route::delete('roles/{role}', [AdminRoleController::class, 'destroy'])->name('roles.destroy');
            
            // Permission Management
            Route::get('permissions', [AdminPermissionController::class, 'index'])->name('permissions.index');
            Route::get('permissions/create', [AdminPermissionController::class, 'create'])->name('permissions.create');
            Route::post('permissions', [AdminPermissionController::class, 'store'])->name('permissions.store');
            Route::get('permissions/{permission}', [AdminPermissionController::class, 'show'])->name('permissions.show');
            Route::get('permissions/{permission}/edit', [AdminPermissionController::class, 'edit'])->name('permissions.edit');
            Route::patch('permissions/{permission}', [AdminPermissionController::class, 'update'])->name('permissions.update');
            Route::delete('permissions/{permission}', [AdminPermissionController::class, 'destroy'])->name('permissions.destroy');
            
            // Tenant Management
            Route::get('tenants', [AdminTenantController::class, 'index'])->name('tenants.index');
            Route::get('tenants/create', [AdminTenantController::class, 'create'])->name('tenants.create');
            Route::post('tenants', [AdminTenantController::class, 'store'])->name('tenants.store');
            Route::get('tenants/{tenant}', [AdminTenantController::class, 'show'])->name('tenants.show');
            Route::get('tenants/{tenant}/edit', [AdminTenantController::class, 'edit'])->name('tenants.edit');
            Route::patch('tenants/{tenant}', [AdminTenantController::class, 'update'])->name('tenants.update');
            Route::delete('tenants/{tenant}', [AdminTenantController::class, 'destroy'])->name('tenants.destroy');
        });
});
