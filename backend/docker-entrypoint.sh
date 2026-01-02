#!/bin/bash

set -e

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:show 2>/dev/null || [ $? -eq 0 ]; do
  echo "Database is unavailable - sleeping"
  sleep 2
done

echo "Database is up!"

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database if it's empty
echo "Checking if database needs seeding..."
if php artisan tinker --execute="echo \App\Models\User::count();" | grep -q "^0$"; then
    echo "Database is empty. Running seeders..."
    php artisan db:seed --force
else
    echo "Database already has data. Skipping seeding."
fi

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting application..."
exec "$@"
