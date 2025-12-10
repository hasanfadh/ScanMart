#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Clear any cached config
php artisan config:clear
php artisan cache:clear

# Create required tables
echo "📦 Creating cache and session tables..."
php artisan cache:table
php artisan session:table
php artisan queue:table

# Run all migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Cache configuration for performance
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the server
echo "✅ Server starting on port 8080..."
php artisan serve --host=0.0.0.0 --port=8080