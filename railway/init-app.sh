#!/bin/bash

echo "================================================"
echo "  🚀 Inhutani Land — Init Phase"
echo "================================================"

# Generate APP_KEY kalo belum ada
php artisan key:generate --force

# Buat SQLite database kalo belum ada
touch database/database.sqlite

# Set storage permissions
chmod -R 777 storage bootstrap/cache

# Jalankan migrasi
php artisan migrate --force

# Seed data (kalo tabel masih kosong)
php artisan db:seed --class=DatabaseSeeder --force

echo "✅ Init complete — starting server..."
