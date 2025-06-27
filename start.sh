#!/bin/bash

# Copy .env.example ke .env jika belum ada
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Install dependency composer
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate app key
php artisan key:generate

# Jalankan migrasi jika kamu pakai database
php artisan migrate --force

# Start Laravel
php artisan serve --host=0.0.0.0 --port=10000
