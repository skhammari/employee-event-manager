#!/bin/bash

# Set environment variables
DB_PASSWORD="secret123"
DB_ROOT_PASSWORD="secret123"

# Copy environment file
cp .env.example .env

# Configure environment
sed -i "s/DB_HOST=.*/DB_HOST=mysql/" .env
sed -i "s/REDIS_HOST=.*/REDIS_HOST=redis/" .env
sed -i "s/APP_ENV=.*/APP_ENV=production/" .env
sed -i "s/APP_DEBUG=.*/APP_DEBUG=false/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env
sed -i "s/DB_ROOT_PASSWORD=.*/DB_ROOT_PASSWORD=$DB_ROOT_PASSWORD/" .env

# Install Composer dependencies
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    composer:latest composer install --optimize-autoloader --no-dev

# Start Sail with production configuration
SAIL_FILES=docker-compose.sail.yml ./vendor/bin/sail up -d

# Wait for database to be ready
echo "Waiting for database to be ready..."
sleep 30

# Setup application
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --force
./vendor/bin/sail artisan db:seed --class=AdminUserSeeder --force
./vendor/bin/sail artisan db:seed --class=EventSeeder --force

# Install and build frontend assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

# Set proper permissions
sudo chown -R $USER:$USER .
sudo find . -type f -exec chmod 644 {} \;
sudo find . -type d -exec chmod 755 {} \;
sudo chown -R www-data:www-data storage bootstrap/cache

# Optimize for production
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache

echo "Deployment completed!"
echo "Admin panel: http://localhost/admin"
echo "Member area: http://localhost/member"
echo ""
echo "Default admin credentials:"
echo "Email: admin@example.com"
echo "Password: password" 