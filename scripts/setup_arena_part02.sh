#!/bin/bash

curl -s "https://laravel.build/roig-arena?with=mysql,redis,meilisearch,mailpit,selenium" | bash

sudo chown -R $USER:$USER ./roig-arena

cd roig-arena
cp -rf ../scripts/data/compose.yaml ./compose.yaml
./vendor/bin/sail up -d

## Configuración SANCTUM
./vendor/bin/sail composer require laravel/sanctum
./vendor/bin/sail artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
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
./vendor/bin/sail artisan migrate:fresh

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

echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc

echo "Ejecuta source ~/.bashrc para poder usar el alias de sail"