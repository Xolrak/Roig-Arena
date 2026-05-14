#!/bin/bash

## SEEDERS
cp -rf ../scripts/data/database/seeders/SectorSeeder.php ./database/seeders/SectorSeeder.php
cp -rf ../scripts/data/database/seeders/AsientoSeeder.php ./database/seeders/AsientoSeeder.php
cp -rf ../scripts/data/database/seeders/UserSeeder.php ./database/seeders/UserSeeder.php
cp -rf ../scripts/data/database/seeders/EventoSeeder.php ./database/seeders/EventoSeeder.php
cp -rf ../scripts/data/database/seeders/PrecioSeeder.php ./database/seeders/PrecioSeeder.php
cp -rf ../scripts/data/database/seeders/DatabaseSeeder.php ./database/seeders/DatabaseSeeder.php
./vendor/bin/sail artisan migrate:fresh --seed