#!/usr/bin/env bash

# Jalankan migrasi (opsional, kalau pakai DB)
php artisan migrate --force

# Jalankan Laravel pakai PHP built-in server
php artisan serve --host=0.0.0.0 --port=$PORT
