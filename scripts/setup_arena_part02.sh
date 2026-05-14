#!/bin/bash

curl -s "https://laravel.build/roig-arena?with=mysql,redis,meilisearch,mailpit,selenium" | bash

cd roig-arena
cp -rf ./scripts/data/compose.yaml ./compose.yaml
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
./vendor/bin/sail artisan migrate:fresh --seed

## Migraciones
cp -rf ../scripts/data/database/migrations/0001_01_01_000000_create_users_table.php ./database/migrations/0001_01_01_000000_create_users_table.php
cp -rf ../scripts/data/database/migrations/2026_02_07_193317_create_roig_arena_tables.php ./database/migrations/2026_02_07_193317_create_roig_arena_tables.php
./vendor/bin/sail artisan migrate

echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc

echo "Ejecuta source ~/.bashrc para poder usar el alias de sail"