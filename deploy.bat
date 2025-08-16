@echo off
echo 🚀 Deploying MTR API...
echo.

echo 🐳 Building and starting containers...
docker-compose up -d --build

echo 🍪 Configuring sessions...
powershell -Command "(Get-Content .env) -replace 'SESSION_DRIVER=database', 'SESSION_DRIVER=file' | Set-Content .env"

echo ⚙️  Configuring Laravel...
docker-compose exec app chown www:www .env
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan key:generate --force
docker-compose exec app php artisan jwt:secret --force
docker-compose exec app php artisan config:clear

echo 📁 Configuring session directory...
docker-compose exec app mkdir -p storage/framework/sessions
docker-compose exec app chown -R www:www storage/framework/sessions
docker-compose exec app php artisan config:clear

echo 🚀 Optimizing performance...
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

echo.
echo ✅ Deployment completed!
echo 🌐 API available at: http://localhost:8080
echo 🔑 Login with: worozco / 12345
echo.
pause 