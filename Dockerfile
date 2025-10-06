# 1️⃣ Gunakan PHP CLI + Composer
FROM php:8.1-cli

# 2️⃣ Install dependencies sistem & PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# 3️⃣ Copy composer dari image official
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Set working directory
WORKDIR /var/www/html

# 5️⃣ Copy semua file Laravel
COPY . .

# 6️⃣ Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Expose port untuk Render
EXPOSE 10000

# 8️⃣ Jalankan Laravel server
CMD php artisan serve --host=0.0.0.0 --port=10000
