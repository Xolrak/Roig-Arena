#!/bin/bash
set -e  # Salir si hay error

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Funciones auxiliares
log_info() { echo -e "${GREEN}[INFO]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[WARN]${NC} $1"; }
log_error() { echo -e "${RED}[ERROR]${NC} $1"; }

# Definir estructura de copias
declare -A COPY_TASKS=(
    ["config"]="app/Models/User.php config/cors.php"
    ["bootstrap"]="bootstrap/app.php bootstrap/appv2.php"
    ["routes"]="routes/api.php routes/console.php routes/apiv2.php routes/apiv3.php"
    ["controllers"]="app/Http/Controllers/Auth/AuthController.php app/Http/Controllers/Auth/AuthControllerv2.php app/Http/Controllers/EventoController.php app/Http/Controllers/SectorController.php app/Http/Controllers/AsientoController.php app/Http/Controllers/ReservaController.php app/Http/Controllers/CompraController.php app/Http/Controllers/EntradaController.php"
    ["middleware"]="app/Http/Middleware/IsAdmin.php app/Http/Middleware/IsAdminv2.php"
    ["resources"]="app/Http/Resources/AsientoResource.php app/Http/Resources/EntradaResource.php app/Http/Resources/EventoResource.php app/Http/Resources/ReservaResource.php app/Http/Resources/SectorResource.php app/Http/Resources/UserResource.php app/Http/Resources/PrecioResource.php"
    ["services"]="app/Services/CompraService.php app/Services/LiberarReservasService.php app/Services/ReservaService.php"
    ["models"]="app/Models/Sector.php app/Models/Asiento.php app/Models/Evento.php app/Models/Precio.php app/Models/EstadoAsiento.php app/Models/Entrada.php app/Models/Userv2.php"
)

# Función para crear directorios necesarios
create_directories() {
    log_info "Creando directorios necesarios..."
    mkdir -p app/Models app/Http/Controllers/Auth app/Http/Middleware app/Http/Resources \
             app/Services app/Console/Commands database/migrations database/seeders database/factories tests
}

# Función para copiar archivos por categoría
copy_files() {
    # Copia completa desde la carpeta preparada para el proyecto
    local SOURCE_DIR="../scripts/roig-arena"

    log_info "Copiando todo el contenido de $SOURCE_DIR hacia el directorio actual..."
    if [ -d "$SOURCE_DIR" ]; then
        # Usar dot para incluir archivos ocultos; -r para recursivo, -p para preservar permisos, -f para forzar
        cp -rpf "$SOURCE_DIR/." ./ || { log_error "Error al copiar $SOURCE_DIR"; exit 1; }
    else
        log_warn "Directorio $SOURCE_DIR no encontrado — saltando copia de carpeta."
    fi
}

# Función principal
main() {
    log_info "Iniciando setup part02 de Roig-Arena..."
    mv ./roig-arena ./scripts/
    # Crear proyecto
    log_info "Creando proyecto Laravel con laravel.build..."
    curl -s "https://laravel.build/roig-arena?with=mysql,redis,meilisearch,mailpit,selenium" | bash
    
    # Permisos
    sudo chown -R $USER:$USER ./roig-arena
    
    # Entrar al directorio
    cd roig-arena || { log_error "No se pudo entrar a roig-arena"; exit 1; }
    
    # Compose y sail
    log_info "Configurando compose.yaml y levantando servicios..."
    ./vendor/bin/sail up -d
    
    # Sanctum
    log_info "Instalando Laravel Sanctum..."
    ./vendor/bin/sail composer require laravel/sanctum
    ./vendor/bin/sail artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    
    # Normalizar migración Sanctum
    log_info "Normalizando migración de Sanctum..."
    mv ./database/migrations/*_create_personal_access_tokens_table.php ./database/migrations/2026_05_18_000000_create_personal_access_tokens_table.php 2>/dev/null || true
    
    # Preparar directorios
    create_directories
    
    # Copiar archivos
    copy_files
    
    # Limpiar config
    ./vendor/bin/sail artisan config:clear
    
    # Generar stubs necesarios (se sobrescriben después)
    log_info "Generando stubs iniciales..."
    ./vendor/bin/sail artisan make:controller Auth/AuthController || true
    ./vendor/bin/sail artisan make:middleware IsAdmin || true
    
    # Ejecutar migraciones
    log_info "Ejecutando migraciones..."
    ./vendor/bin/sail artisan migrate:fresh --seed
    
    # Alias de sail
    log_info "Configurando alias de sail..."
    if ! grep -q "alias sail=" ~/.bashrc; then
        echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
        log_info "Alias agregado a ~/.bashrc"
    else
        log_warn "Alias de sail ya existe en ~/.bashrc"
    fi
    
    log_info "${GREEN}✓ Setup part02 completado exitosamente${NC}"
    log_warn "Ejecuta: source ~/.bashrc para activar el alias de sail"
}

# Ejecutar
main
