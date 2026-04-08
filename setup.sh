#!/bin/bash

echo "================================================"
echo "  Laravel SaaS Application Setup Script"
echo "================================================"
echo ""

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "Error: Please run this script from the Laravel application directory"
    exit 1
fi

# Ask for MySQL credentials
read -p "MySQL Username [root]: " DB_USERNAME
DB_USERNAME=${DB_USERNAME:-root}

read -sp "MySQL Password: " DB_PASSWORD
echo ""

read -p "MySQL Host [127.0.0.1]: " DB_HOST
DB_HOST=${DB_HOST:-127.0.0.1}

read -p "Database Name [laravel_saas]: " DB_DATABASE
DB_DATABASE=${DB_DATABASE:-laravel_saas}

echo ""
echo "================================================"
echo "  Creating Database"
echo "================================================"

# Try to create the database
mysql -h "$DB_HOST" -u "$DB_USERNAME" ${DB_PASSWORD:+-p"$DB_PASSWORD"} -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✓ Database '$DB_DATABASE' created successfully"
else
    echo "⚠ Could not create database. Please create it manually:"
    echo "  CREATE DATABASE $DB_DATABASE CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    echo ""
fi

echo ""
echo "================================================"
echo "  Updating .env File"
echo "================================================"

# Update .env file
sed -i "s/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/" .env
sed -i "s/# DB_HOST=127.0.0.1/DB_HOST=$DB_HOST/" .env
sed -i "s/# DB_DATABASE=laravel/DB_DATABASE=$DB_DATABASE/" .env
sed -i "s/# DB_USERNAME=root/DB_USERNAME=$DB_USERNAME/" .env
sed -i "s/# DB_PASSWORD=/DB_PASSWORD=$DB_PASSWORD/" .env

echo "✓ .env file updated"

echo ""
echo "================================================"
echo "  Running Migrations and Seeders"
echo "================================================"

php artisan migrate:fresh --seed --force

if [ $? -eq 0 ]; then
    echo "✓ Database migrated and seeded successfully"
else
    echo "✗ Error running migrations. Please check your database credentials."
    exit 1
fi

echo ""
echo "================================================"
echo "  Setup Complete!"
echo "================================================"
echo ""
echo "You can now start the development server:"
echo "  php artisan serve"
echo ""
echo "Default login credentials:"
echo "  Super Admin: admin@example.com / password"
echo "  Admin:       admin2@example.com / password"
echo "  Manager:      manager@example.com / password"
echo "  User:        user@example.com / password"
echo ""
