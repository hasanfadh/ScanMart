FROM dunglas/frankenphp:php8.2-bookworm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nodejs npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy and install dependencies
COPY composer.json composer.lock package.json package-lock.json ./
RUN composer install --optimize-autoloader --no-dev --no-scripts --no-interaction
RUN npm ci

# Copy application
COPY . .

# Build assets
RUN npm run build && npm prune --omit=dev

# Setup permissions
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Copy start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]