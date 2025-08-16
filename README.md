# MTR API - Proyecto Universitario

API de Laravel con autenticación JWT para gestión de matrículas.

## 🚀 Deployment Rápido

### Prerrequisitos
- **Docker Desktop** instalado
  - En Windows: Descargar desde [docker.com](https://www.docker.com/products/docker-desktop/)
  - Habilitar WSL2 (recomendado)
- **MySQL** ejecutándose en el host (puerto 3306)

### Pasos

#### En Linux/macOS:
1. **Clonar el repositorio**
   ```bash
   git clone <url-del-repositorio>
   cd mtr-api-25
   ```

2. **Ejecutar deployment**
   ```bash
   ./deploy.sh
   ```

#### En Windows:
1. **Clonar el repositorio**
   ```cmd
   git clone <url-del-repositorio>
   cd mtr-api-25
   ```

2. **Ejecutar deployment**
   ```cmd
   deploy.bat
   ```

3. **¡Listo!** La API estará disponible en `http://localhost:8080`

## 🔑 Credenciales de Prueba
- **Usuario**: `worozco`
- **Contraseña**: `12345`

## 📋 Endpoints Principales

### Autenticación
- `POST /api/auth/login` - Iniciar sesión
- `POST /api/auth/logout` - Cerrar sesión
- `GET /api/auth/me` - Información del usuario

### Ejemplo de Login
```bash
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"acceso": "worozco", "secreto": "12345"}'
```

## 🛠️ Comandos Útiles

```bash
# Ver logs
docker-compose logs -f

# Parar servicios
docker-compose down

# Reiniciar
docker-compose restart

# Acceder al contenedor
docker-compose exec app sh
```

## 📁 Estructura del Proyecto
```
mtr-api-25/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── docker-compose.yml
├── Dockerfile
├── deploy.sh
└── README.md
```

## ⚠️ Solución de Problemas

### En Windows:
- **Error "Docker Desktop no está ejecutándose"**: Abrir Docker Desktop y esperar a que inicie completamente
- **Error de permisos**: Ejecutar como administrador
- **Error de WSL2**: Habilitar WSL2 en Windows Features

### En cualquier sistema:
- **Error de conexión a MySQL**: Verificar que MySQL esté ejecutándose en el puerto 3306
- **Error de puerto ocupado**: Cambiar el puerto en `docker-compose.yml` (línea `"8080:80"`)

¡Simple y directo! 🎉
