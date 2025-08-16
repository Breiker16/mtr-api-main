#!/bin/bash

echo "🚀 Deploying MTR API..."
echo

# 1. Construir y levantar contenedores
echo "🐳 Building and starting containers..."
docker-compose up -d --build

# 2. Configurar sesiones en archivos (desde el host)
echo "🍪 Configuring sessions..."
sed -i '' 's/SESSION_DRIVER=database/SESSION_DRIVER=file/' .env

# 3. Configurar Laravel
echo "⚙️  Configuring Laravel..."
docker-compose exec app chown www:www .env
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan key:generate --force
docker-compose exec app php artisan jwt:secret --force
docker-compose exec app php artisan config:clear

# 4. Configurar directorio de sesiones
docker-compose exec app mkdir -p storage/framework/sessions
docker-compose exec app chown -R www:www storage/framework/sessions
docker-compose exec app php artisan config:clear

# 5. Optimizar rendimiento
echo "🚀 Optimizing performance..."
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

echo
echo "✅ Deployment completed!"
echo "🌐 API available at: http://localhost:8080"
echo "🔑 Login with: worozco / 12345"
echo 