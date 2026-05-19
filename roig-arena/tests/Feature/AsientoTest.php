<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Evento;
use App\Models\Sector;
use App\Models\Asiento;
use App\Models\Precio;
use App\Models\EstadoAsiento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AsientoTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_asiento_con_reserva_expirada_se_muestra_disponible()
    {
        $evento = Evento::factory()->create();
        $sector = Sector::factory()->create(['activo' => true]);
        $asiento = Asiento::factory()->create(['sector_id' => $sector->id]);

        Precio::factory()->create([
            'evento_id' => $evento->id,
            'sector_id' => $sector->id,
            'precio' => 40.00,
            'disponible' => true,
        ]);

        EstadoAsiento::create([
            'evento_id' => $evento->id,
            'asiento_id' => $asiento->id,
            'user_id' => null,
            'estado' => 'bloqueado',
            'reservado_hasta' => now()->subMinute(),
        ]);

        $response = $this->getJson("/api/eventos/{$evento->id}/asientos");

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $asiento->id);
        $response->assertJsonPath('data.0.disponible', true);
    }

    public function test_el_endpoint_por_sector_solo_devuelve_los_asientos_de_ese_sector()
    {
        $evento = Evento::factory()->create();
        $sectorPrincipal = Sector::factory()->create(['nombre' => 'PISTA', 'activo' => true]);
        $sectorSecundario = Sector::factory()->create(['nombre' => 'Sector 301', 'activo' => true]);

        $asientoPrincipal = Asiento::factory()->create([
            'sector_id' => $sectorPrincipal->id,
            'fila' => 'A',
            'numero' => 1,
        ]);
        Asiento::factory()->create([
            'sector_id' => $sectorSecundario->id,
            'fila' => 'B',
            'numero' => 2,
        ]);

        Precio::factory()->create([
            'evento_id' => $evento->id,
            'sector_id' => $sectorPrincipal->id,
            'precio' => 80.00,
            'disponible' => true,
        ]);
        Precio::factory()->create([
            'evento_id' => $evento->id,
            'sector_id' => $sectorSecundario->id,
            'precio' => 40.00,
            'disponible' => true,
        ]);

        $response = $this->getJson("/api/eventos/{$evento->id}/sectores/{$sectorPrincipal->id}/asientos");

        $response->assertOk();
        $response->assertJsonCount(1, 'data.asientos');
        $response->assertJsonPath('data.sector.id', $sectorPrincipal->id);
        $response->assertJsonPath('data.asientos.0.id', $asientoPrincipal->id);
    }
}
