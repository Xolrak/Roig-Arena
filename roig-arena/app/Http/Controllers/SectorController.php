<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use App\Models\Evento;
use App\Models\Precio;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    /**
     * Listar sectores activos (público)
     */
    public function index()
    {
        $sectores = Sector::activos()
            ->withCount('asientos')
            ->get();

        return response()->json([
            'data' => $sectores,
        ]);
    }

    /**
     * Crear sector (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:sectores',
            'descripcion' => 'nullable|string',
            'asientos_total' => 'required|integer|min:1|max:5000',
            'precio_base' => 'required|numeric|min:0.01',
            'activo' => 'boolean',
        ]);

        $sector = DB::transaction(function () use ($request) {
            $sector = Sector::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'asientos_total' => (int) $request->asientos_total,
                'precio_base' => $request->precio_base,
                'activo' => $request->boolean('activo', true),
            ]);

            $this->crearAsientosSector($sector, (int) $request->asientos_total);
            $this->sincronizarPreciosSectorEnEventosFuturos($sector);

            return $sector->loadCount('asientos');
        });

        return response()->json([
            'data' => $sector,
            'message' => 'Sector creado correctamente',
        ], 201);
    }

    /**
     * Actualizar sector (admin)
     */
    public function update(Request $request, $id)
    {
        $sector = Sector::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|string|max:255|unique:sectores,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'asientos_total' => 'sometimes|integer|min:1|max:5000',
            'precio_base' => 'sometimes|numeric|min:0.01',
            'activo' => 'boolean',
        ]);

        try {
            DB::transaction(function () use ($request, $sector) {
                $data = $request->only(['nombre', 'descripcion', 'activo']);

                if ($request->has('precio_base')) {
                    $data['precio_base'] = $request->precio_base;
                }

                if ($request->has('asientos_total')) {
                    $asientosTotal = (int) $request->asientos_total;
                    $actual = $sector->totalAsientos();

                    if ($asientosTotal < $actual) {
                        throw new \Exception('No se puede reducir la capacidad de un sector con asientos creados');
                    }

                    $data['asientos_total'] = $asientosTotal;
                }

                $sector->update($data);

                if ($request->has('asientos_total')) {
                    $this->crearAsientosSector($sector->fresh(), (int) $request->asientos_total);
                }

                if ($request->has('precio_base')) {
                    $this->sincronizarPreciosSectorEnEventosFuturos($sector->fresh());
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'data' => $sector->fresh()->loadCount('asientos'),
            'message' => 'Sector actualizado correctamente',
        ]);
    }

    /**
     * Eliminar sector (admin)
     */
    public function destroy($id)
    {
        $sector = Sector::findOrFail($id);
        
        // Verificar que no tenga asientos
        if ($sector->totalAsientos() > 0) {
            return response()->json([
                'error' => 'No se puede eliminar un sector con asientos',
            ], 400);
        }

        $sector->delete();

        return response()->json([
            'message' => 'Sector eliminado correctamente',
        ]);
    }

    private function crearAsientosSector(Sector $sector, int $asientosTotal): void
    {
        $actual = $sector->asientos()->count();

        if ($actual >= $asientosTotal) {
            return;
        }

        $nuevosAsientos = [];
        $numeroBase = $actual + 1;
        $seatsPerRow = 20;

        for ($indice = $numeroBase; $indice <= $asientosTotal; $indice++) {
            $rowIndex = (int) ceil($indice / $seatsPerRow) - 1;
            $fila = $this->convertirIndiceAFila($rowIndex);
            $numero = (($indice - 1) % $seatsPerRow) + 1;

            $nuevosAsientos[] = [
                'sector_id' => $sector->id,
                'fila' => $fila,
                'numero' => $numero,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($nuevosAsientos, 1000) as $chunk) {
            Asiento::insert($chunk);
        }
    }

    private function sincronizarPreciosSectorEnEventosFuturos(Sector $sector): void
    {
        $precioBase = $sector->precioBaseEfectivo();

        Evento::futuros()->get()->each(function (Evento $evento) use ($sector, $precioBase) {
            Precio::updateOrCreate(
                [
                    'evento_id' => $evento->id,
                    'sector_id' => $sector->id,
                ],
                [
                    'precio' => round($precioBase * $this->multiplicadorEvento($evento), 2),
                    'disponible' => true,
                ]
            );
        });
    }

    private function multiplicadorEvento(Evento $evento): float
    {
        return match ($evento->nombre) {
            'Final Copa del Rey' => 1.5,
            'Concierto Rock 2026' => 1.3,
            'Festival Electrónica' => 1.2,
            default => 1.0,
        };
    }

    private function convertirIndiceAFila(int $indice): string
    {
        $indice++;
        $fila = '';

        while ($indice > 0) {
            $resto = ($indice - 1) % 26;
            $fila = chr(65 + $resto) . $fila;
            $indice = intdiv($indice - 1, 26);
        }

        return $fila;
    }
}