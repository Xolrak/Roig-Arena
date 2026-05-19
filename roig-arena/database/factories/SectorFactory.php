<?php

namespace Database\Factories;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectorFactory extends Factory
{
    protected $model = Sector::class;

    public function definition(): array
    {
        return [
            'nombre' => 'Sector ' . $this->faker->numberBetween(101, 323),
            'descripcion' => $this->faker->sentence(),
            'asientos_total' => $this->faker->numberBetween(8, 300),
            'precio_base' => $this->faker->randomFloat(2, 40, 150),
            'activo' => true,
        ];
    }
}