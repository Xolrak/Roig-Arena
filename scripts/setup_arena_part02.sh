#!/bin/bash

curl -s "https://laravel.build/roig-arena?with=mysql,redis,meilisearch,mailpit,selenium" | bash

cd roig-arena
cp -rf ./scripts/data/compose.yaml ./roig-arena/
./vendor/bin/sail up -d

## Configuración SANCTUM
./vendor/bin/sail composer require laravel/sanctum
./vendor/bin/sail artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
cp -rf ./scripts/data/app/Models/User.php ./roig-arena/app/Models/User.php
cp -rf ./scripts/data/app/config/cors.php ./roig-arena/app/config/cors.php
cp -rf ./scripts/data/.env ./roig-arena/.env
./vendor/bin/sail artisan config:clear
cp -rf ./scripts/data/bootstrap/app.php ./roig-arena/bootstrap/app.php
cp -rf ./scripts/data/routes/api.php ./roig-arena/routes/api.php
./vendor/bin/sail artisan make:controller Auth/AuthController
cp -rf ./scripts/data/app/Http/Controllers/AuthController.php ./roig-arena/app/Http/Controllers/AuthController.php
./vendor/bin/sail artisan make:middleware IsAdmin
cp -rf ./app/Http/Middleware/IsAdmin.php
cp -rf ./scripts/data/bootstrap/appv2.php ./roig-arena/bootstrap/app.php
sail artisan migrate

echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc

echo "Ejecuta source ~/.bashrc para poder usar el alias de sail"