#!/bin/bash
set -e

echo "================================================"
echo "  🚀 Inhutani Land Management — Starting..."
echo "================================================"

# 1. Copy .env.example ke .env kalo belum ada (Railway gak punya .env)
if [ ! -f .env ]; then
    echo "📄 Creating .env from .env.example..."
    cp .env.example .env
fi

# 2. Buat SQLite database kalo belum ada
echo "🗄️  Ensuring SQLite database exists..."
touch database/database.sqlite

# 3. Set permission storage
echo "🔓 Setting storage permissions..."
chmod -R 777 storage bootstrap/cache

# 4. Generate APP_KEY (override kalo masih dummy)
echo "🔑 Generating APP_KEY..."
php artisan key:generate --force

# 5. Jalankan migrasi
echo "📦 Running migrations..."
php artisan migrate --force

# 6. Seed data (kalo tabel masih kosong)
echo "🌱 Seeding database..."
php artisan db:seed --class=DatabaseSeeder --force

echo ""
echo "================================================"
echo "  ✅ Ready! Listening on port $PORT"
echo "================================================"

# 7. Start server
php artisan serve --host=0.0.0.0 --port=$PORT
