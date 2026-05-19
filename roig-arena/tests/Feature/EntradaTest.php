<?php

namespace Tests\Feature;

use App\Models\Asiento;
use App\Models\EstadoAsiento;
use App\Models\Evento;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntradaTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_listado_de_entradas_muestra_evento_y_asiento_completos(): void
    {
        $user = User::factory()->create();
        $sector = Sector::factory()->create(['nombre' => 'Principal']);

        $eventoUno = Evento::factory()->create(['nombre' => 'Concierto Uno']);
        $eventoDos = Evento::factory()->create(['nombre' => 'Concierto Dos']);

        $asientoUno = Asiento::factory()->create([
            'sector_id' => $sector->id,
            'fila' => 'A',
            'numero' => 12,
        ]);
        $asientoDos = Asiento::factory()->create([
            'sector_id' => $sector->id,
            'fila' => 'B',
            'numero' => 7,
        ]);

        $reservaUno = EstadoAsiento::factory()->create([
            'evento_id' => $eventoUno->id,
            'asiento_id' => $asientoUno->id,
            'user_id' => $user->id,
            'reservado_hasta' => now()->addMinutes(10),
        ]);

        $reservaDos = EstadoAsiento::factory()->create([
            'evento_id' => $eventoDos->id,
            'asiento_id' => $asientoDos->id,
            'user_id' => $user->id,
            'reservado_hasta' => now()->addMinutes(10),
        ]);

        $this->actingAs($user)->postJson('/api/compras', [
            'reservas' => [$reservaUno->id, $reservaDos->id],
        ])->assertCreated();

        $response = $this->actingAs($user)->getJson('/api/entradas');

        $response->assertOk();
        $response->assertJsonCount(2, 'data');

        $entradas = collect($response->json('data'));

        $this->assertTrue($entradas->contains(fn (array $entrada) =>
            $entrada['evento']['nombre'] === 'Concierto Uno'
            && $entrada['asiento']['sector'] === 'Principal'
            && $entrada['asiento']['fila'] === 'A'
            && $entrada['asiento']['numero'] === 12
        ));

        $this->assertTrue($entradas->contains(fn (array $entrada) =>
            $entrada['evento']['nombre'] === 'Concierto Dos'
            && $entrada['asiento']['sector'] === 'Principal'
            && $entrada['asiento']['fila'] === 'B'
            && $entrada['asiento']['numero'] === 7
        ));
    }
}