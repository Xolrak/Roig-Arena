# Roig-Arena

Proyecto de API para la gestión de reservas y venta de entradas en un recinto (Arena). Está construido sobre **Laravel**, utilizando **Laravel Sail** (Docker) como entorno de desarrollo.

## Estructura del Proyecto

El proyecto está dividido en dos partes principales:

- `scripts/`: Contiene los scripts automatizados en Bash para aprovisionar y levantar todo el entorno, desde la instalación de dependencias del sistema hasta la configuración del proyecto Laravel y la ejecución de tests.
- `roig-arena/`: Contiene el código fuente de la aplicación Laravel propiamente dicha, exponiendo un API para la gestión de eventos, sectores, asientos, reservas y compra de entradas.

## Proceso de Instalación y Configuración

El despliegue local del proyecto está orquestado mediante 3 scripts clave situados en la carpeta `scripts/`. Se recomienda ejecutarlos en orden en una máquina Debian/Ubuntu:

### 1. Preparación del Sistema (`setup_arena_part01.sh`)
Este script prepara tu máquina host instalando las herramientas esenciales:
- Limpia instalaciones previas y dependencias no utilizadas.
- Actualiza los repositorios.
- Instala dependencias base (iptables, ca-certificates, curl, gnupg).
- Configura e instala el motor de **Docker** (Docker Engine, CLI, containerd y plugins) y **PHP-CLI**.
- Agrega tu usuario al grupo de Docker y reinicia los servicios.
*Nota: Después de ejecutar este script, es necesario reiniciar tu sesión o la máquina para que los permisos del grupo Docker apliquen.*

### 2. Creación del Proyecto Laravel (`setup_arena_part02.sh`)
Este script se encarga de descargar y configurar la estructura base de Laravel y los contenedores:
- Inicializa un proyecto Laravel usando `laravel.build` con servicios preconfigurados (MySQL, Redis, Meilisearch, Mailpit y Selenium).
- Levanta los contenedores con **Laravel Sail** (`sail up -d`).
- Instala **Laravel Sanctum** para la autenticación de la API.
- Genera la estructura de carpetas necesaria (Controladores, Modelos, Middleware, Servicios, etc.).
- Copia los archivos del proyecto (ubicados en un directorio de respaldo interno) a la estructura del nuevo proyecto Laravel.
- Ejecuta las migraciones de base de datos (`migrate:fresh --seed`).
- Añade un alias de `sail` a tu archivo `~/.bashrc` para facilitar la ejecución de comandos.

### 3. Configuración de Pruebas y Datos Muestra (`setup_tests.sh`)
Este script prepara el entorno de pruebas e inyecta los datos semilla (seeders):
- Copia los *Seeders* (Sectores, Asientos, Usuarios, Eventos, Precios) y ejecuta una migración fresca con el poblado de base de datos.
- Copia los *Factories* necesarios para generar datos de prueba.
- Copia e inicializa todos los *Tests* (Unitarios y de Integración/Features) cubriendo funcionalidades como Autenticación, Gestión de Eventos, Reservas, Compras y Servicios (ej. liberación de reservas expiradas).

## Estructura de Directorios de la Aplicación (`roig-arena/`)

Dentro de la aplicación Laravel, los directorios más relevantes para el funcionamiento del Arena son:

### `app/` (Lógica de Negocio)
Contiene todo el código base de la aplicación.
- **`Http/Controllers`**: Aloja los controladores RESTful (ej. `EventoController`, `SectorController`) que manejan las peticiones API.
- **`Models`**: Define los modelos Eloquent (ej. `Evento`, `Asiento`, `Reserva`) que interactúan con la base de datos.
- **`Services`**: Clases de servicio para encapsular la lógica de negocio compleja, aislando esta lógica de los controladores (ej. `ReservaService`, `CompraService`).

### `config/` (Configuración)
Almacena todos los archivos de configuración del framework. Aquí se configuran servicios clave como la base de datos (`database.php`), el intercambio de recursos CORS (`cors.php`) o el sistema de autenticación de tokens (`sanctum.php`).

### `routes/` (Rutas)
Define todos los puntos de entrada (endpoints) de la aplicación. Las definiciones del API REST se agrupan en `api.php`, declarando qué controlador y método responde a cada petición, así como la protección mediante middlewares (ej. `auth:sanctum`, `IsAdmin`).

### `database/` (Base de Datos)
Centraliza la definición del esquema y la generación de datos para la base de datos MySQL de la aplicación.
- **`migrations/`**: Define de forma programática el esquema de la base de datos (tablas, columnas, claves foráneas). Permite controlar el versionado de la estructura de la base de datos.
- **`factories/`**: Generadores de datos ficticios pero estructurados (ej. `AsientoFactory`, `EventoFactory`). Son clave para crear datos de prueba durante la ejecución de los tests.
- **`seeders/`**: Clases (ej. `DatabaseSeeder`, `SectorSeeder`) utilizadas para insertar datos iniciales en la base de datos. Se utilizan para establecer el catálogo base necesario (sectores, usuarios) tanto en desarrollo como en producción o testing.

## Características de la API (roig-arena)

La aplicación web (`roig-arena/`) expone controladores RESTful para la lógica de negocio del Arena:

- **Autenticación (AuthController):** Registro, login y manejo de tokens mediante Sanctum.
- **Eventos (EventoController):** Gestión de la cartelera y eventos disponibles en el Arena.
- **Sectores y Asientos (SectorController, AsientoController):** Control del aforo, zonas, graderíos y estados de los asientos (disponible, reservado, ocupado).
- **Reservas (ReservaController):** Bloqueo temporal de asientos antes de realizar el pago efectivo. Funciona en conjunto con *ReservaService* y *LiberarReservasService* para liberar aquellas reservas que expiren sin confirmarse.
- **Compras y Entradas (CompraController, EntradaController):** Transaccionalidad de la compra y emisión final de las entradas asociadas a los asientos.

### Tecnologías Principales
- **Backend:** PHP 8.3+, Laravel, Laravel Sanctum
- **Entorno de Desarrollo:** Docker (Laravel Sail)
- **Base de Datos:** MySQL
- **Frontend / Compilación:** Vite, TailwindCSS (pre-configurado)
- **Testing:** PHPUnit / Pest (mediante `sail artisan test`)

---
**Comando útil de desarrollo:**
Una vez instalados, puedes interactuar con el contenedor mediante:
```bash
sail up -d          # Para levantar servicios
sail artisan test   # Para correr pruebas
sail artisan route:list # Para ver todas las rutas API
```