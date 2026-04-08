# Routes Documentation

This document provides a complete overview of all routes in the Laravel SaaS application.

## Table of Contents

- [Web Routes](#web-routes)
  - [Public Routes](#public-routes)
  - [Guest Routes](#guest-routes-authentication-required)
  - [Authenticated Routes](#authenticated-routes)
  - [Admin Routes](#admin-routes-super-admin-only)
- [API Routes](#api-routes)
  - [Public API Routes](#public-api-routes)
  - [Protected API Routes](#protected-api-routes)

---

## Web Routes

All web routes are located in `routes/web.php`

### Public Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/` | `home` | Landing page |

### Guest Routes (Authentication Required)

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/login` | `login` | Login form |
| POST | `/login` | - | Process login |
| GET | `/register` | `register` | Registration form |
| POST | `/register` | - | Process registration |
| GET | `/forgot-password` | `password.request` | Forgot password form |
| POST | `/forgot-password` | `password.email` | Send password reset link |
| GET | `/reset-password/{token}` | `password.reset` | Reset password form |
| POST | `/reset-password` | `password.store` | Process password reset |

### Authenticated Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/verify-email` | `verification.notice` | Email verification notice |
| GET | `/verify-email/{id}/{hash}` | `verification.verify` | Verify email |
| POST | `/email/verification-notification` | `verification.send` | Resend verification email |
| GET | `/confirm-password` | `password.confirm` | Confirm password form |
| POST | `/confirm-password` | - | Process password confirmation |
| PUT | `/password` | `password.update` | Update password |
| POST | `/logout` | `logout` | Logout user |
| GET | `/dashboard` | `dashboard` | User dashboard |
| GET | `/profile` | `profile.edit` | Profile edit form |
| PATCH | `/profile` | `profile.update` | Update profile |

### Admin Routes (Super Admin Only)

All admin routes are prefixed with `/admin` and protected by `role:Super Admin` middleware.

#### Dashboard
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/dashboard` | `admin.dashboard` | Admin dashboard |

#### User Management
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/users` | `admin.users.index` | List all users |
| GET | `/admin/users/create` | `admin.users.create` | Create user form |
| POST | `/admin/users` | `admin.users.store` | Store new user |
| GET | `/admin/users/{user}` | `admin.users.show` | View user details |
| GET | `/admin/users/{user}/edit` | `admin.users.edit` | Edit user form |
| PATCH | `/admin/users/{user}` | `admin.users.update` | Update user |
| DELETE | `/admin/users/{user}` | `admin.users.destroy` | Delete user |

#### Role Management
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/roles` | `admin.roles.index` | List all roles |
| GET | `/admin/roles/create` | `admin.roles.create` | Create role form |
| POST | `/admin/roles` | `admin.roles.store` | Store new role |
| GET | `/admin/roles/{role}` | `admin.roles.show` | View role details |
| GET | `/admin/roles/{role}/edit` | `admin.roles.edit` | Edit role form |
| PATCH | `/admin/roles/{role}` | `admin.roles.update` | Update role |
| DELETE | `/admin/roles/{role}` | `admin.roles.destroy` | Delete role |

#### Permission Management
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/permissions` | `admin.permissions.index` | List all permissions |
| GET | `/admin/permissions/create` | `admin.permissions.create` | Create permission form |
| POST | `/admin/permissions` | `admin.permissions.store` | Store new permission |
| GET | `/admin/permissions/{permission}` | `admin.permissions.show` | View permission details |
| GET | `/admin/permissions/{permission}/edit` | `admin.permissions.edit` | Edit permission form |
| PATCH | `/admin/permissions/{permission}` | `admin.permissions.update` | Update permission |
| DELETE | `/admin/permissions/{permission}` | `admin.permissions.destroy` | Delete permission |

#### Tenant Management
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/tenants` | `admin.tenants.index` | List all tenants |
| GET | `/admin/tenants/create` | `admin.tenants.create` | Create tenant form |
| POST | `/admin/tenants` | `admin.tenants.store` | Store new tenant |
| GET | `/admin/tenants/{tenant}` | `admin.tenants.show` | View tenant details |
| GET | `/admin/tenants/{tenant}/edit` | `admin.tenants.edit` | Edit tenant form |
| PATCH | `/admin/tenants/{tenant}` | `admin.tenants.update` | Update tenant |
| DELETE | `/admin/tenants/{tenant}` | `admin.tenants.destroy` | Delete tenant |

---

## API Routes

All API routes are prefixed with `/api/v1` and located in `routes/api.php`

### Public API Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| POST | `/api/v1/login` | - | User login |
| POST | `/api/v1/register` | - | User registration |
| POST | `/api/v1/forgot-password` | - | Request password reset |
| POST | `/api/v1/reset-password` | - | Reset password |

### Protected API Routes

All protected routes require authentication via Sanctum token.

#### User Profile
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/api/v1/user` | - | Get authenticated user |
| PUT | `/api/v1/profile` | - | Update profile |
| PUT | `/api/v1/password` | - | Update password |
| POST | `/api/v1/logout` | - | Logout (revoke token) |

#### User Management (Admin Only)
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/api/v1/users` | `users.index` | List all users |
| POST | `/api/v1/users` | `users.store` | Create new user |
| GET | `/api/v1/users/{user}` | `users.show` | View user details |
| PUT/PATCH | `/api/v1/users/{user}` | `users.update` | Update user |
| DELETE | `/api/v1/users/{user}` | `users.destroy` | Delete user |
| GET | `/api/v1/users/{user}/roles` | `users.roles` | Get user's roles |
| POST | `/api/v1/users/{user}/roles` | `users.assign-roles` | Assign roles to user |
| DELETE | `/api/v1/users/{user}/roles/{role}` | `users.remove-role` | Remove role from user |

#### Role Management (Admin Only)
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/api/v1/roles` | `roles.index` | List all roles |
| POST | `/api/v1/roles` | `roles.store` | Create new role |
| GET | `/api/v1/roles/{role}` | `roles.show` | View role details |
| PUT/PATCH | `/api/v1/roles/{role}` | `roles.update` | Update role |
| DELETE | `/api/v1/roles/{role}` | `roles.destroy` | Delete role |
| GET | `/api/v1/roles/{role}/permissions` | `roles.permissions` | Get role's permissions |
| POST | `/api/v1/roles/{role}/permissions` | `roles.sync-permissions` | Sync role's permissions |

#### Tenant Management (Admin Only)
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/api/v1/tenants` | `tenants.index` | List all tenants |
| POST | `/api/v1/tenants` | `tenants.store` | Create new tenant |
| GET | `/api/v1/tenants/{tenant}` | `tenants.show` | View tenant details |
| PUT/PATCH | `/api/v1/tenants/{tenant}` | `tenants.update` | Update tenant |
| DELETE | `/api/v1/tenants/{tenant}` | `tenants.destroy` | Delete tenant |
| GET | `/api/v1/tenants/{tenant}/users` | `tenants.users` | Get tenant's users |

---

## Middleware

### Web Middleware
- `guest` - For unauthenticated users
- `auth` - For authenticated users
- `verified` - For users with verified email
- `role:Super Admin` - For Super Admin users only

### API Middleware
- `auth:sanctum` - For API authentication
- `role:Super Admin` - For Super Admin users only
- `permission:manage X` - For users with specific permissions

---

## Route Examples

### Web Route Examples

```php
// Redirect to dashboard
return redirect()->route('dashboard');

// Get user profile
return view('profile.edit', [
    'user' => request()->user(),
]);

// Admin route protection
Route::middleware(['role:Super Admin'])->prefix('admin')->group(function () {
    // Admin routes here
});
```

### API Route Examples

```php
// Login request
$response = Http::post('/api/v1/login', [
    'email' => 'user@example.com',
    'password' => 'password',
]);

// Use token for authenticated requests
$response = Http::withToken($token)->get('/api/v1/user');

// Create user (Admin only)
$response = Http::withToken($token)->post('/api/v1/users', [
    'name' => 'New User',
    'email' => 'new@example.com',
    'password' => 'password',
]);
```

---

## Broadcasting Channels

Located in `routes/channels.php`:

- `App.Models.User.{id}` - User-specific private channel
- `tenant.{tenantId}` - Tenant-specific channel
- `admin` - Admin-only channel

---

## Scheduled Commands

Located in `routes/console.php`:

- Database backup: Daily at 00:00
- Cache clear: Every hour
- Session cleanup: Daily at 03:00
