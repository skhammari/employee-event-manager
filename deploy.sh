#!/bin/bash

# Update system
sudo apt-get update
sudo apt-get upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Install required packages
sudo apt-get install -y git unzip

# Clone the repository (replace with your repo URL)
git clone https://github.com/yourusername/your-repo.git
cd your-repo

# Copy environment file
cp .env.example .env

# Update environment variables
sed -i "s/DB_HOST=.*/DB_HOST=mysql/" .env
sed -i "s/REDIS_HOST=.*/REDIS_HOST=redis/" .env
sed -i "s/APP_URL=.*/APP_URL=http:\/\/${DOMAIN}/" .env
sed -i "s/APP_ENV=.*/APP_ENV=production/" .env
sed -i "s/APP_DEBUG=.*/APP_DEBUG=false/" .env

# Install Composer dependencies
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    composer:latest composer install --optimize-autoloader --no-dev

# Start Sail
./vendor/bin/sail up -d

# Generate application key
./vendor/bin/sail artisan key:generate

# Run migrations and seeders
./vendor/bin/sail artisan migrate --force
./vendor/bin/sail artisan db:seed --class=AdminUserSeeder --force
./vendor/bin/sail artisan db:seed --class=EventSeeder --force

# Set proper permissions
sudo chown -R $USER:$USER .
sudo find . -type f -exec chmod 644 {} \;
sudo find . -type d -exec chmod 755 {} \;
sudo chown -R www-data:www-data storage bootstrap/cache

# Install and build frontend assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

# Clear all caches
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache

echo "Deployment completed! Your application should be running at http://${DOMAIN}"
echo "Admin panel: http://${DOMAIN}/admin"
echo "Member area: http://${DOMAIN}/member" 