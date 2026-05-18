<?php

namespace Database\Factories;

use App\Models\Precio;
use App\Models\EstadoAsiento;
use App\Models\Evento;
use App\Models\Asiento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoAsientoFactory extends Factory
{
    protected $model = EstadoAsiento::class;

    public function definition(): array
    {
        return [
            'evento_id' => Evento::factory(),
            'asiento_id' => Asiento::factory(),
            'user_id' => User::factory(),
            'estado' => 'bloqueado',
            'reservado_hasta' => now()->addMinutes(15),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (EstadoAsiento $estadoAsiento) {
            $estadoAsiento->loadMissing('asiento');

            Precio::factory()->create([
                'evento_id' => $estadoAsiento->evento_id,
                'sector_id' => $estadoAsiento->asiento->sector_id,
            ]);
        });
    }

    public function vendido(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'vendido',
            'reservado_hasta' => null,
        ]);
    }

    public function expirado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'bloqueado',
            'reservado_hasta' => now()->subMinutes(20),
        ]);
    }
}