#!/bin/bash

curl -s "https://laravel.build/roig-arena?with=mysql,redis,meilisearch,mailpit,selenium" | bash

cp -rf ./scripts/roig-arena.data/* ./roig-arena/
rm -rf ./scripts/roig-arena.data

cd roig-arena
./vendor/bin/sail up -d
./vendor/bin/sail composer require laravel/sanctum
sail artisan migrate:fresh --seed

echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc

echo "Ejecuta source ~/.bashrc para poder usar el alias de sail"