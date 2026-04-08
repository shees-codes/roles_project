# Laravel 12 SaaS Application

A complete Laravel 12 SaaS application with multi-tenancy, role-based access control (RBAC), and authentication built-in.

## Features

### Authentication System
- User registration and login
- Password reset functionality
- Email verification
- Session management
- Profile management

### Multi-Tenancy
- Tenant management (organizations/companies)
- Each tenant can have multiple users
- Tenant-specific user assignments

### Role-Based Access Control (RBAC)
- Multiple roles (Super Admin, Admin, Manager, User)
- Granular permissions system
- Role-permission assignment
- User-role assignment

### Admin Panel
- User management (CRUD)
- Role management (CRUD)
- Permission management (CRUD)
- Tenant management (CRUD)

## Requirements

- PHP 8.3+
- Composer
- MySQL/MariaDB or SQLite
- Web server (Apache/Nginx)

## Installation

1. **Clone the repository:**
   ```bash
   cd /var/www/laravel-saas
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   ```

4. **Update `.env` file** with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_saas
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Create database:**
   ```sql
   CREATE DATABASE laravel_saas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

6. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

7. **Run migrations and seeders:**
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Start the development server:**
   ```bash
   php artisan serve
   ```

## Default Users

After seeding, the following users are created:

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@example.com | password |
| Admin | admin2@example.com | password |
| Manager | manager@example.com | password |
| User | user@example.com | password |

## Access Control

### Roles

1. **Super Admin** - Full access to all features
2. **Admin** - Access to admin panel (users, tenants management)
3. **Manager** - Access to admin panel (limited)
4. **User** - Basic user access

### Permissions

- `access admin panel` - Can access the admin dashboard
- `manage users` - Can manage users
- `manage roles` - Can manage roles
- `manage permissions` - Can manage permissions
- `manage tenants` - Can manage tenants

## Project Structure

```
laravel-saas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/          # Authentication controllers
│   │   │   ├── Admin/        # Admin panel controllers
│   │   │   └── Profile/      # Profile controller
│   │   └── Middleware/
│   └── Models/
│       ├── User.php
│       └── Tenant.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php  # Seeds default data
├── resources/
│   └── views/
│       ├── auth/              # Authentication views
│       ├── admin/            # Admin panel views
│       ├── dashboard.blade.php
│       └── profile/
└── routes/
    └── web.php
```

## Routes

### Authentication Routes
- `/login` - User login
- `/register` - User registration
- `/forgot-password` - Password reset request
- `/reset-password/{token}` - Password reset form

### Dashboard Routes
- `/dashboard` - Main dashboard
- `/profile` - Profile settings

### Admin Routes (requires Super Admin role)
- `/admin/users` - User management
- `/admin/roles` - Role management
- `/admin/permissions` - Permission management
- `/admin/tenants` - Tenant management

## Usage

### Assigning Roles to Users

```php
use App\Models\User;
use Spatie\Permission\Models\Role;

$user = User::find(1);
$role = Role::where('name', 'Admin')->first();
$user->assignRole($role);
```

### Checking Permissions

```php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

// Check if user has a role
if ($user->hasRole('Super Admin')) {
    // Do something
}

// Check if user has a permission
if ($user->hasPermissionTo('manage users')) {
    // Do something
}
```

### Creating a New Tenant

```php
use App\Models\Tenant;

$tenant = Tenant::create([
    'name' => 'New Company',
    'slug' => 'new-company',
    'domain' => 'newcompany.example.com',
    'is_active' => true,
]);
```

## Customization

### Adding New Permissions

1. Edit `database/seeders/DatabaseSeeder.php`
2. Add new permission to the `$permissions` array
3. Run `php artisan migrate:fresh --seed`

### Creating Custom Roles

1. Go to Admin Panel → Roles → Create New Role
2. Assign the desired permissions
3. Assign the role to users

## Troubleshooting

### Database Connection Issues

Make sure your MySQL credentials are correct in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_saas
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Permission Denied on Storage Directory

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Development

### Running Tests

```bash
php artisan test
```

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Security

- All passwords are hashed using bcrypt
- CSRF protection enabled on all forms
- SQL injection prevention through Eloquent ORM
- XSS protection through Laravel's blade templating

## License

This project is open-sourced software licensed under the MIT license.
