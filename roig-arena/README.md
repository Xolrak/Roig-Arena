# Roig Arena — Plataforma de Venta de Entradas

**Sistema web y API para la compra de entradas del Roig Arena, sede del Valencia Basket Club**

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)]()
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white)]()
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)]()
[![License](https://img.shields.io/badge/license-MIT-green)]()

---

## Descripción General

Roig Arena es una **plataforma moderna y escalable** para la venta de entradas del Roig Arena, implementada con Laravel 11 y Vue.js. Proporciona una experiencia intuitiva de compra con:

- ✨ **Interfaz moderna** basada en design system propietario  
- 🎟️ **Gestión integral de eventos, asientos y precios**  
- 🔐 **Autenticación segura** con reservas temporales  
- 💳 **Integración de pagos** (preparada para proveedores)  
- 📊 **APIs REST** para terceros  
- 🧪 **Suite de tests** unitarios y de características  

---

## Índice

- [Requisitos Previos](#requisitos-previos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Desarrollo](#desarrollo)
- [Testing](#testing)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Flujos Principales](#flujos-principales)
- [APIs](#apis)
- [Design System](#design-system)
- [Deployment](#deployment)
- [Contribuir](#contribuir)

---

## Requisitos Previos

Para desarrollar en este proyecto **no necesitas instalar PHP o Node localmente**. Utilizamos **Laravel Sail** para aislar el ambiente:

- **Docker Desktop** (versión 20+)  
- **Docker Compose** (versión 2.0+)  
- **Git**  

Verifica que Docker está funcionando:

```bash
docker --version
docker-compose --version
```

---

## Instalación

### 1. Clonar el Repositorio

```bash
git clone <repository-url>
cd Roig-Arena/roig-arena
```

### 2. Configurar Variables de Entorno

```bash
cp .env.example .env
```

Edita `.env` con tus valores (base de datos, APIs externas, etc.).

### 3. Construir el Contenedor y Levantar Sail

```bash
./vendor/bin/sail build
./vendor/bin/sail up -d
```

Si es la primera vez, Sail descargará e instalará todas las dependencias PHP y Node dentro del contenedor.

### 4. Instalar Dependencias PHP y JavaScript

```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

### 5. Generar la Clave de la Aplicación

```bash
./vendor/bin/sail artisan key:generate
```

### 6. Ejecutar Migraciones y Seeders

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

### 7. Compilar Assets

```bash
./vendor/bin/sail npm run build
```

La aplicación estará disponible en `http://localhost`.

---

## Configuración

### Variables de Entorno Importantes

```env
APP_NAME=RoigArena
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=roig_arena
DB_USERNAME=sail
DB_PASSWORD=password

SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
```

Para detalles completos, consulta `.env.example`.

---

## Desarrollo

### Comandos Útiles de Sail

```bash
# Levantar contenedores
./vendor/bin/sail up -d

# Detener contenedores
./vendor/bin/sail down

# Ver logs
./vendor/bin/sail logs -f

# Acceder al bash del contenedor
./vendor/bin/sail shell

# Ejecutar Artisan
./vendor/bin/sail artisan <comando>

# Ejecutar tests
./vendor/bin/sail test

# Ejecutar npm
./vendor/bin/sail npm run dev
```

### Desarrollo en Caliente

Para desarrollo con recarga automática de assets:

```bash
./vendor/bin/sail npm run dev
```

En otra terminal, deja Sail corriendo:

```bash
./vendor/bin/sail up
```

### Estructura de Rutas

```
routes/
├── web.php          # Rutas web (vistas)
├── api.php          # Rutas API (REST)
└── console.php      # Comandos Artisan
```

---

## Testing

### Ejecutar Todos los Tests

```bash
./vendor/bin/sail test
```

### Ejecutar Tests Específicos

```bash
# Solo tests unitarios
./vendor/bin/sail test --filter=Unit

# Solo tests de características
./vendor/bin/sail test --filter=Feature

# Un test específico
./vendor/bin/sail test tests/Unit/LiberarReservasServiceTest.php
```

### Cobertura de Código

```bash
./vendor/bin/sail test --coverage
```

---

## Estructura del Proyecto

```
roig-arena/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Controladores (Evento, Auth, etc.)
│   │   ├── Middleware/          # Middlewares (CORS, autenticación)
│   │   └── Resources/           # API Resources
│   ├── Models/                  # Eloquent Models (Evento, Entrada, etc.)
│   ├── Services/                # Lógica de negocio (CompraService, ReservaService)
│   └── Console/
│       └── Commands/            # Comandos Artisan
├── database/
│   ├── factories/               # Model factories para tests
│   ├── migrations/              # Migraciones
│   └── seeders/                 # Seeders
├── resources/
│   ├── js/                      # Componentes Vue.js
│   ├── css/                     # Estilos (Tailwind CSS)
│   └── views/                   # Vistas Blade (si las hay)
├── routes/                      # Definición de rutas
├── tests/
│   ├── Unit/                    # Tests unitarios
│   ├── Feature/                 # Tests de características
│   └── TestCase.php             # Clase base de tests
├── config/                      # Configuración de la aplicación
├── storage/                     # Logs, cache, uploads
├── vite.config.js               # Configuración de Vite
├── phpunit.xml                  # Configuración de PHPUnit
└── composer.json                # Dependencias PHP
```

---

## Flujos Principales

### 1. Flujo de Compra (CheckoutFlow)

```
Cliente → Selecciona Evento
        → Elige Asientos
        → Crea Reserva (temporal)
        → Procesa Pago
        → Genera Entrada Digital
        → Confirmación
```

**Servicios involucrados:**
- `ReservaService` — Crea y gestiona reservas temporales  
- `CompraService` — Procesa la compra completa  
- `LiberarReservasService` — Libera asientos no pagados después de N minutos  

### 2. Gestión de Eventos

Los eventos contienen:
- **Sectores** (Zona VIP, Palco, Grada, etc.)
- **Precios** por sector y categoría (general, junior, senior)
- **Asientos** con estado (disponible, reservado, vendido)

### 3. Autenticación

Utiliza **Laravel Sanctum** para tokens API stateless.

---

## APIs

### Endpoints Principales

#### Eventos
```http
GET    /api/eventos              # Listar eventos
GET    /api/eventos/:id         # Detalle de evento
GET    /api/eventos/:id/asientos # Mapa de asientos
```

#### Compras
```http
POST   /api/reservas            # Crear reserva
POST   /api/compras             # Procesar compra
GET    /api/mis-entradas        # Mis entradas (autenticado)
```

#### Autenticación
```http
POST   /api/auth/register       # Registro
POST   /api/auth/login          # Login
POST   /api/auth/logout         # Logout (autenticado)
```

Para documentación completa, consulta `routes/api.php`.

---

## Design System

Roig Arena implementa un **design system propietario** basado en la identidad del Valencia Basket Club.

**Colores principales:**
- **Taronja** (#FF6C0C) — Naranja corporativo, acciones principales  
- **Arena Black** (#0A0B0C) — Negro del logotipo  
- **Blau VBC** (#009FE3) — Azul secundario  

Para detalles completos, consulta [roig-arena-design-system.md](../roig-arena-design-system.md).

---

## Deployment

### Preparar para Producción

```bash
# Build de assets
./vendor/bin/sail npm run build

# Optimizar para producción
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache
```

### Sugerencias de Hosting

- **Servidor**: PHP 8.3+, Node.js 20+, MySQL 8.0+  
- **Recomendado**: Heroku, AWS EC2, DigitalOcean, Vercel (frontend)  
- **CDN**: CloudFlare para assets estáticos  

---

## Contribuir

### Buenas Prácticas

1. **Crea una rama** para tu feature:
   ```bash
   git checkout -b feature/mi-feature
   ```

2. **Escribe tests** para tu código:
   ```bash
   ./vendor/bin/sail test
   ```

3. **Sigue las convenciones** del proyecto (Laravel, PSR-12)

4. **Haz un Pull Request** con descripción clara

### Convenciones

- **Controllers**: Verbos singulares (`EventoController`)  
- **Models**: Singular (`Evento`, `Entrada`)  
- **Services**: Nombre + `Service` (`CompraService`)  
- **Tests**: Nombre modelo + tipo test (`LiberarReservasServiceTest`)  

---

## Troubleshooting

### Los contenedores no inician
```bash
docker system prune -a
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d
```

### Error: "Laravel installation not found"
```bash
composer install
./vendor/bin/sail build
```

### Base de datos no se migra
```bash
./vendor/bin/sail artisan migrate:fresh
./vendor/bin/sail artisan db:seed
```

### npm no encuentra módulos
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

---

## Soporte

Para problemas o preguntas:
- 📧 Contacta al equipo de desarrollo  
- 🐛 Reporta bugs en el sistema de issues  
- 📚 Revisa la documentación de [Laravel](https://laravel.com/docs)  

---

## Licencia

Este proyecto está licenciado bajo la [MIT License](LICENSE).
