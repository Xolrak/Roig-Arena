#!/bin/bash

# Asegurarse de estar en la raíz del proyecto (donde está composer.json)
# Si el script se lanza desde scripts/, volvemos a la raíz
# cd ~/Roig-Arena/roig-arena

echo "🚀 Iniciando configuración de Sanctum y migración de archivos..."

## 1. Configuración SANCTUM
./vendor/bin/sail composer require laravel/sanctum
./vendor/bin/sail artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

## 2. Copia de archivos (Corrigiendo Rutas)
# Origen: ../scripts/data/
# Destino: ./ (carpeta actual del proyecto)

echo "📂 Copiando modelos y configuración..."
cp -rf ../scripts/data/app/Models/User.php ./app/Models/User.php
cp -rf ../scripts/data/config/cors.php ./config/cors.php
cp -rf ../scripts/data/.env ./.env

echo "📂 Copiando lógica de rutas y bootstrap..."
cp -rf ../scripts/data/bootstrap/app.php ./bootstrap/app.php
cp -rf ../scripts/data/routes/api.php ./routes/api.php

echo "📂 Configurando Controladores y Middleware..."
# Creamos la carpeta de Auth por si no existe
mkdir -p ./app/Http/Controllers/Auth

# Copiamos el controlador (ojo a la ruta del origen en tu carpeta data)
cp -rf ../scripts/data/app/Http/Controllers/Auth/AuthController.php ./app/Http/Controllers/Auth/AuthController.php
cp -rf ../scripts/data/app/Http/Middleware/IsAdmin.php ./app/Http/Middleware/IsAdmin.php

## 3. Limpieza y Regeneración
echo "🧹 Limpiando cachés y regenerando autoload..."
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail composer dump-autoload

## 4. Base de Datos
echo "🗄️ Ejecutando migraciones..."
./vendor/bin/sail artisan migrate

echo "✅ Proceso finalizado. Prueba ahora el registro con el comando curl."