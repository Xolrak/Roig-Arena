#!/bin/bash

curl -s "https://laravel.build/roig-arena?with=mysql,redis,meilisearch,mailpit,selenium" | bash

sudo chown -R $USER:$USER ./roig-arena

cd roig-arena
cp -rf ../scripts/data/compose.yaml ./compose.yaml
./vendor/bin/sail up -d

## Configuración SANCTUM
./vendor/bin/sail composer require laravel/sanctum
./vendor/bin/sail artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Normalizamos el nombre de la migración de Sanctum para que no use marcas de tiempo aleatorias
# Esto evita que se duplique si vuelve a correr el script y garantiza que exista para los tests
mv ./database/migrations/*_create_personal_access_tokens_table.php ./database/migrations/2026_05_18_000000_create_personal_access_tokens_table.php 2>/dev/null || true

cp -rf ../scripts/data/app/Models/User.php ./app/Models/User.php
cp -rf ../scripts/data/config/cors.php ./config/cors.php
cp -rf ../scripts/data/.env ./.env
./vendor/bin/sail artisan config:clear
cp -rf ../scripts/data/bootstrap/app.php ./bootstrap/app.php
cp -rf ../scripts/data/routes/api.php ./routes/api.php
./vendor/bin/sail artisan make:controller Auth/AuthController
cp -rf ../scripts/data/app/Http/Controllers/Auth/AuthController.php ./app/Http/Controllers/Auth/AuthController.php
./vendor/bin/sail artisan make:middleware IsAdmin
cp -rf ../scripts/data/app/Http/Middleware/IsAdmin.php ./app/Http/Middleware/IsAdmin.php
cp -rf ../scripts/data/bootstrap/appv2.php ./bootstrap/app.php

## MIGRACIONES
mkdir -p ./database/migrations
cp -rf ../scripts/data/database/migrations/0001_01_01_000000_create_users_table.php ./database/migrations/0001_01_01_000000_create_users_table.php
cp -rf ../scripts/data/database/migrations/2026_02_07_193317_create_roig_arena_tables.php ./database/migrations/2026_02_07_193317_create_roig_arena_tables.php

## MODELOS ELOQUENT
mkdir -p ./app/Models
cp -rf ../scripts/data/app/Models/Sector.php ./app/Models/Sector.php
cp -rf ../scripts/data/app/Models/Asiento.php ./app/Models/Asiento.php
cp -rf ../scripts/data/app/Models/Evento.php ./app/Models/Evento.php
cp -rf ../scripts/data/app/Models/Precio.php ./app/Models/Precio.php
cp -rf ../scripts/data/app/Models/EstadoAsiento.php ./app/Models/EstadoAsiento.php
cp -rf ../scripts/data/app/Models/Entrada.php ./app/Models/Entrada.php
cp -rf ../scripts/data/app/Models/Userv2.php ./app/Models/User.php

## CONTROLADORES
cp -rf ../scripts/data/app/Http/Controllers/Auth/AuthControllerv2.php ./app/Http/Controllers/Auth/AuthController.php
cp -rf ../scripts/data/app/Http/Controllers/EventoController.php ./app/Http/Controllers/EventoController.php
cp -rf ../scripts/data/app/Http/Controllers/SectorController.php ./app/Http/Controllers/SectorController.php
cp -rf ../scripts/data/app/Http/Controllers/AsientoController.php ./app/Http/Controllers/AsientoController.php
cp -rf ../scripts/data/app/Http/Controllers/ReservaController.php ./app/Http/Controllers/ReservaController.php
cp -rf ../scripts/data/app/Http/Controllers/CompraController.php ./app/Http/Controllers/CompraController.php
cp -rf ../scripts/data/app/Http/Controllers/EntradaController.php ./app/Http/Controllers/EntradaController.php
cp -rf ../scripts/data/routes/apiv2.php ./routes/api.php

## RESOURCES
mkdir -p ./app/Http/Resources
cp -rf ../scripts/data/app/Http/Resources/AsientoResource.php ./app/Http/Resources/AsientoResource.php
cp -rf ../scripts/data/app/Http/Resources/EntradaResource.php ./app/Http/Resources/EntradaResource.php
cp -rf ../scripts/data/app/Http/Resources/EventoResource.php ./app/Http/Resources/EventoResource.php
cp -rf ../scripts/data/app/Http/Resources/ReservaResource.php ./app/Http/Resources/ReservaResource.php
cp -rf ../scripts/data/app/Http/Resources/SectorResource.php ./app/Http/Resources/SectorResource.php
cp -rf ../scripts/data/app/Http/Resources/UserResource.php ./app/Http/Resources/UserResource.php
cp -rf ../scripts/data/app/Http/Resources/PrecioResource.php ./app/Http/Resources/PrecioResource.php

## SERVICES
mkdir -p ./app/Services
cp -rf ../scripts/data/app/Services/CompraService.php ./app/Services/CompraService.php
cp -rf ../scripts/data/app/Services/LiberarReservasService.php ./app/Services/LiberarReservasService.php
cp -rf ../scripts/data/app/Services/ReservaService.php ./app/Services/ReservaService.php
mkdir -p ./app/Console/Commands
cp -rf ../scripts/data/app/Console/Commands/LiberarReservasExpiradas.php ./app/Console/Commands/LiberarReservasExpiradas.php
cp -rf ../scripts/data/routes/console.php ./routes/console.php

## Creación de Middleware
cp -rf ../scripts/data/app/Http/Middleware/IsAdminv2.php ./app/Http/Middleware/IsAdmin.php

cp -rf ../scripts/data/routes/apiv3.php ./routes/api.php

## SEEDERS
mkdir -p ./database/seeders
cp -rf ../scripts/data/database/seeders/AsientoSeeder.php ./database/seeders/AsientoSeeder.php
cp -rf ../scripts/data/database/seeders/DatabaseSeeder.php ./database/seeders/DatabaseSeeder.php
cp -rf ../scripts/data/database/seeders/EventoSeeder.php ./database/seeders/EventoSeeder.php
cp -rf ../scripts/data/database/seeders/PrecioSeeder.php ./database/seeders/PrecioSeeder.php
cp -rf ../scripts/data/database/seeders/SectorSeeder.php ./database/seeders/SectorSeeder.php
cp -rf ../scripts/data/database/seeders/UserSeeder.php ./database/seeders/UserSeeder.php

## FACTORIES
mkdir -p ./database/factories
cp -rf ../scripts/data/database/factories/AsientoFactory.php ./database/factories/AsientoFactory.php
cp -rf ../scripts/data/database/factories/EntradaFactory.php ./database/factories/EntradaFactory.php
cp -rf ../scripts/data/database/factories/EstadoAsientoFactory.php ./database/factories/EstadoAsientoFactory.php
cp -rf ../scripts/data/database/factories/EventoFactory.php ./database/factories/EventoFactory.php
cp -rf ../scripts/data/database/factories/PrecioFactory.php ./database/factories/PrecioFactory.php
cp -rf ../scripts/data/database/factories/SectorFactory.php ./database/factories/SectorFactory.php
cp -rf ../scripts/data/database/factories/UserFactory.php ./database/factories/UserFactory.php

## TESTS
mkdir -p ./tests
cp -rf ../scripts/tests/* ./tests/

# Copia de seguridad genérica final respetando la migración estructurada de tokens
cp -rf ../scripts/roig-arena/* ./ 2>/dev/null || true

## EJECUCIÓN DE BASE DE DATOS
./vendor/bin/sail artisan migrate:fresh --seed

echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc

echo "Ejecuta source ~/.bashrc para poder usar el alias de sail"