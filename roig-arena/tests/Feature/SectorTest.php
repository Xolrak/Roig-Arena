<?php

namespace Tests\Feature;

use App\Models\Sector;
use App\Models\Evento;
use App\Models\Precio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectorTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_puede_crear_sector(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $evento = Evento::factory()->create(['fecha' => now()->addDay()]);

        $response = $this->actingAs($admin)->postJson('/api/admin/sectores', [
            'nombre' => 'Sector VIP',
            'descripcion' => 'Zona preferente',
            'asientos_total' => 24,
            'precio_base' => 65.50,
            'activo' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('sectores', [
            'nombre' => 'Sector VIP',
        ]);
        $sector = Sector::where('nombre', 'Sector VIP')->firstOrFail();
        $this->assertSame(24, $sector->asientos()->count());
        $this->assertDatabaseHas('precios', [
            'evento_id' => $evento->id,
            'sector_id' => $sector->id,
        ]);
        $this->assertSame(65.5, (float) Precio::where('evento_id', $evento->id)->where('sector_id', $sector->id)->value('precio'));
    }

    public function test_usuario_normal_no_puede_crear_sector(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->postJson('/api/admin/sectores', [
            'nombre' => 'Sector VIP',
            'descripcion' => 'Zona preferente',
            'activo' => true,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_puede_actualizar_sector(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $sector = Sector::factory()->create([
            'nombre' => 'Sector A',
            'asientos_total' => 20,
            'precio_base' => 50.00,
        ]);

        $response = $this->actingAs($admin)->putJson("/api/admin/sectores/{$sector->id}", [
            'nombre' => 'Sector Renovado',
            'precio_base' => 55.00,
            'activo' => false,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('sectores', [
            'id' => $sector->id,
            'nombre' => 'Sector Renovado',
            'activo' => 0,
        ]);
    }

    public function test_admin_puede_eliminar_sector_sin_asientos(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $sector = Sector::factory()->create();

        $response = $this->actingAs($admin)->deleteJson("/api/admin/sectores/{$sector->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('sectores', [
            'id' => $sector->id,
        ]);
    }
}