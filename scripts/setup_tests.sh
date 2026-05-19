#!/bin/bash

cd roig-arena
## SEEDERS
cp -rf ../scripts/data/database/seeders/SectorSeeder.php ./database/seeders/SectorSeeder.php
cp -rf ../scripts/data/database/seeders/AsientoSeeder.php ./database/seeders/AsientoSeeder.php
cp -rf ../scripts/data/database/seeders/UserSeeder.php ./database/seeders/UserSeeder.php
cp -rf ../scripts/data/database/seeders/EventoSeeder.php ./database/seeders/EventoSeeder.php
cp -rf ../scripts/data/database/seeders/PrecioSeeder.php ./database/seeders/PrecioSeeder.php
cp -rf ../scripts/data/database/seeders/DatabaseSeeder.php ./database/seeders/DatabaseSeeder.php
./vendor/bin/sail artisan migrate:fresh --seed

## FACTORIES
cp -rf ../scripts/data/database/factories/SectorFactory.php ./database/factories/SectorFactory.php
cp -rf ../scripts/data/database/factories/AsientoFactory.php ./database/factories/AsientoFactory.php
cp -rf ../scripts/data/database/factories/EventoFactory.php ./database/factories/EventoFactory.php
cp -rf ../scripts/data/database/factories/PrecioFactory.php ./database/factories/PrecioFactory.php
cp -rf ../scripts/data/database/factories/EstadoAsientoFactory.php ./database/factories/EstadoAsientoFactory.php
cp -rf ../scripts/data/database/factories/EntradaFactory.php ./database/factories/EntradaFactory.php

## TESTS
# features
cp -rf ../scripts/data/tests/Feature/AuthTest.php ./tests/Feature/AuthTest.php
cp -rf ../scripts/data/tests/Feature/EventoTest.php ./tests/Feature/EventoTest.php
cp -rf ../scripts/data/tests/Feature/ReservaTest.php ./tests/Feature/ReservaTest.php
cp -rf ../scripts/data/tests/Feature/CompraTest.php ./tests/Feature/CompraTest.php
# unit
cp -rf ../scripts/data/tests/Unit/ModeloTest.php ./tests/Unit/ModeloTest.php
cp -rf ../scripts/data/tests/Unit/ReservaServiceTest.php ./tests/Unit/ReservaServiceTest.php
cp -rf ../scripts/data/tests/Unit/CompraServiceTest.php ./tests/Unit/CompraServiceTest.php
cp -rf ../scripts/data/tests/Unit/LiberarReservasServiceTest.php ./tests/Unit/LiberarReservasServiceTest.php