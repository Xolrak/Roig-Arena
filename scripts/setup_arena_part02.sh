#!/bin/bash

curl -s "https://laravel.build/roig-arena?with=mysql,redis,meilisearch,mailpit,selenium" | bash

cd roig-arena
./vendor/bin/sail up -d

echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc

echo "Ejecuta source ~/.bashrc para poder usar el alias de sail"