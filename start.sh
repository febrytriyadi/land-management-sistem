#!/bin/bash
set -e

echo "🚀 Inhutani Land — Starting..."

# 1. Buat SQLite database kalo belum ada
touch database/database.sqlite

# 2. Set permission storage
chmod -R 777 storage bootstrap/cache

# 3. Generate APP_KEY (kalo belum ada / masih dummy)
php artisan key:generate --force

# 4. Jalankan migrasi
php artisan migrate --force

# 5. Seed data (kalo tabel masih kosong)
php artisan db:seed --class=DatabaseSeeder --force

echo "✅ Ready! Starting server on port $PORT"
php artisan serve --host=0.0.0.0 --port=$PORT
