<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\EstadoAsiento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class LiberarReservasCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_comando_liberar_reservas_elimina_las_expiradas()
    {
        $reservaExpirada = EstadoAsiento::factory()->create([
            'estado' => 'bloqueado',
            'reservado_hasta' => now()->subSeconds(1),
        ]);

        $reservaActiva = EstadoAsiento::factory()->create([
            'estado' => 'bloqueado',
            'reservado_hasta' => now()->addMinutes(2),
        ]);

        $codigo = Artisan::call('reservas:liberar');

        $this->assertSame(0, $codigo);
        $this->assertDatabaseMissing('estado_asientos', ['id' => $reservaExpirada->id]);
        $this->assertDatabaseHas('estado_asientos', ['id' => $reservaActiva->id]);
    }
}