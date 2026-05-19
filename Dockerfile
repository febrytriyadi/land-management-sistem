FROM php:8.3-cli

# Set working directory
WORKDIR /app

# Install system dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        sqlite3 \
        mbstring \
        xml \
        zip \
        bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Generate APP_KEY and create storage structure
RUN php artisan key:generate --force && \
    mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache database

# Create SQLite database if not exists
RUN touch database/database.sqlite && chmod 666 database/database.sqlite

# Run migrations and seed on container start
CMD php artisan migrate --force && \
    php artisan db:seed --class=DatabaseSeeder --force && \
    echo "✅ Inhutani Land ready on port $PORT" && \
    php artisan serve --host=0.0.0.0 --port=$PORT
