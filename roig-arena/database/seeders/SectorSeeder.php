<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    public function run(): void
    {
        $sectores = [];

        // Sectores 101-122
        for ($i = 101; $i <= 122; $i++) {
            $sectores[] = ['nombre' => "Sector $i", 'descripcion' => 'Grada lateral', 'asientos_total' => 300, 'precio_base' => 50.00, 'activo' => true];
        }

        // Sectores 301-323
        for ($i = 301; $i <= 323; $i++) {
            $sectores[] = ['nombre' => "Sector $i", 'descripcion' => 'Grada superior', 'asientos_total' => 300, 'precio_base' => 40.00, 'activo' => true];
        }

        // Palcos 1-22
        for ($i = 1; $i <= 22; $i++) {
            $sectores[] = ['nombre' => "Palco $i", 'descripcion' => 'Palco VIP', 'asientos_total' => 8, 'precio_base' => 150.00, 'activo' => true];
        }

        // Sectores especiales
        $sectores[] = ['nombre' => 'CLUB', 'descripcion' => 'Zona Club', 'asientos_total' => 200, 'precio_base' => 100.00, 'activo' => true];
        $sectores[] = ['nombre' => 'JOHNNIE WALKER', 'descripcion' => 'Zona Johnnie Walker', 'asientos_total' => 120, 'precio_base' => 90.00, 'activo' => true];
        $sectores[] = ['nombre' => 'PISTA', 'descripcion' => 'Pista central', 'asientos_total' => 750, 'precio_base' => 80.00, 'activo' => true];
        $sectores[] = ['nombre' => 'FRONT STAGE', 'descripcion' => 'Frente al escenario', 'asientos_total' => 150, 'precio_base' => 120.00, 'activo' => true];

        foreach ($sectores as $sector) {
            Sector::create($sector);
        }

        $this->command->info('✅ Sectores creados: ' . count($sectores));
    }
}