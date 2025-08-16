# 🐳 MTR API - Despliegue con Docker

Este documento describe cómo desplegar la API de Laravel usando Docker, aprovechando tu infraestructura MySQL existente.

## 📋 Prerrequisitos

- Docker y Docker Compose instalados
- MySQL existente ejecutándose en `localhost:3306`
- Credenciales de MySQL configuradas

## 🚀 Despliegue Rápido

### 1. Verificar MySQL Existente

```bash
./check-mysql.sh
```

Este script verificará:
- ✅ Si MySQL está ejecutándose
- ✅ Conexión con las credenciales configuradas
- ✅ Existencia de la base de datos `db_matricula`
- ✅ Estado de las tablas

### 2. Verificar Seguridad (Opcional)

```bash
./security-check.sh
```

Este script verifica:
- 🔒 Vulnerabilidades en la imagen
- ✅ Configuración de seguridad
- 🛡️ Mejores prácticas implementadas

### 3. Desplegar la Aplicación

```bash
./deploy.sh
```

Este script automatizado:
- 🔧 Configura las variables de entorno
- 🏗️ Construye la imagen de la aplicación
- 🚀 Inicia los servicios (app + redis)
- 📊 Ejecuta migraciones
- 🔑 Genera claves de aplicación y JWT
- 🧹 Limpia cachés
- 📁 Configura permisos

## 🏗️ Arquitectura

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Tu MySQL      │    │   MTR API App   │    │     Redis       │
│   Existente     │◄──►│   (Docker)      │◄──►│   (Docker)      │
│   localhost:3306│    │   localhost:8080│    │   localhost:6379│
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Servicios

| Servicio | Puerto | Descripción |
|----------|--------|-------------|
| **App** | 8080 | API Laravel con Nginx + PHP-FPM |
| **Redis** | 6379 | Caché y sesiones |
| **MySQL** | 3306 | Tu base de datos existente |

## ⚙️ Configuración

### Variables de Entorno

El script `deploy.sh` configura automáticamente:

```env
DB_HOST=host.docker.internal
DB_PORT=3306
DB_DATABASE=db_matricula
DB_USERNAME=root
DB_PASSWORD=root_password
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=redis
```

### Credenciales por Defecto

- **MySQL**: `root` / `root_password`
- **Redis**: `redis_password`
- **API**: `worozco` / `12345`

> ⚠️ **Importante**: Cambia estas contraseñas en producción

## 📝 Comandos Útiles

### Gestión de Contenedores

```bash
# Ver estado de servicios
docker-compose ps

# Ver logs en tiempo real
docker-compose logs -f

# Ver logs de un servicio específico
docker-compose logs -f app

# Parar servicios
docker-compose down

# Reiniciar servicios
docker-compose restart

# Reconstruir imagen
docker-compose build --no-cache app
```

### Acceso a Contenedores

```bash
# Acceder al contenedor de la app
docker-compose exec app sh

# Ejecutar comandos de Laravel
docker-compose exec app php artisan migrate
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:list
```

### Verificación

```bash
# Health check de la API
curl http://localhost:8080/health

# Probar login
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"acceso":"worozco","secreto":"12345"}'
```

## 🔧 Personalización

### Cambiar Credenciales de MySQL

Si tu MySQL usa credenciales diferentes, edita el archivo `.env`:

```env
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### Cambiar Puerto de la API

Edita `docker-compose.yml`:

```yaml
ports:
  - "8080:80"  # Cambia 8080 por el puerto deseado
```

### Agregar Variables de Entorno

Edita `docker-compose.yml` en la sección `environment`:

```yaml
environment:
  - NUEVA_VARIABLE=valor
```

## 🐛 Solución de Problemas

### Error de Conexión a MySQL

```bash
# Verificar que MySQL esté ejecutándose
./check-mysql.sh

# Verificar logs del contenedor
docker-compose logs app
```

### Error de Permisos

```bash
# Configurar permisos manualmente
docker-compose exec app chown -R www:www /var/www/html/storage
docker-compose exec app chown -R www:www /var/www/html/bootstrap/cache
```

### Limpiar Todo y Reconstruir

```bash
# Parar y eliminar contenedores
docker-compose down

# Eliminar volúmenes (¡cuidado con Redis!)
docker-compose down -v

# Reconstruir desde cero
docker-compose build --no-cache
docker-compose up -d
```

## 📊 Monitoreo

### Health Checks

- **API**: `http://localhost:8080/health`
- **MySQL**: Verificado por el script de despliegue
- **Redis**: Health check automático en Docker Compose

### Logs

```bash
# Ver todos los logs
docker-compose logs

# Ver logs de la aplicación
docker-compose logs app

# Ver logs de Redis
docker-compose logs redis
```

## 🔒 Seguridad

- ✅ Headers de seguridad configurados en Nginx
- ✅ Archivos sensibles protegidos
- ✅ Usuario no-root en contenedor
- ✅ Red aislada para contenedores
- ✅ Últimas versiones estables de imágenes (menos vulnerabilidades)
- ✅ Configuración de PHP segura
- ✅ Redis con contraseña
- ✅ Health checks para monitoreo
- ✅ Permisos de archivos restringidos
- ✅ Herramientas innecesarias eliminadas
- ✅ Superficie de ataque reducida

## 📈 Optimizaciones

- 🚀 Imagen Alpine Linux (más ligera)
- 🔄 Multi-stage build para optimizar tamaño
- 📦 Composer optimizado para producción
- 🗜️ Gzip habilitado en Nginx
- 💾 Redis para caché y sesiones

---

**¡Tu API está lista para producción! 🎉** 