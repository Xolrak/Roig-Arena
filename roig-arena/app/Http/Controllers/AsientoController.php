<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Sector;
use App\Models\Asiento;
use Illuminate\Http\Request;

class AsientoController extends Controller
{
    /**
     * Obtener asientos disponibles de un evento
     */
    public function porEvento($eventoId)
    {
        $evento = Evento::findOrFail($eventoId);
        
        // Obtener sectores disponibles
        $sectoresDisponibles = $evento->sectoresDisponibles()->pluck('id');
        
        // Pre-cargar precios y estados para evitar N+1 queries
        $precios = \App\Models\Precio::where('evento_id', $eventoId)
            ->whereIn('sector_id', $sectoresDisponibles)
            ->pluck('precio', 'sector_id');
            
        $asientosOcupados = array_fill_keys(
            \App\Models\EstadoAsiento::where('evento_id', $eventoId)->pluck('asiento_id')->toArray(), 
            true
        );
        
        // Obtener asientos de esos sectores
        $asientos = Asiento::whereIn('sector_id', $sectoresDisponibles)
            ->with('sector')
            ->get()
            ->map(function ($asiento) use ($precios, $asientosOcupados) {
                return [
                    'id' => $asiento->id,
                    'sector' => $asiento->sector->nombre,
                    'fila' => $asiento->fila,
                    'numero' => $asiento->numero,
                    'disponible' => !isset($asientosOcupados[$asiento->id]),
                    'precio' => $precios[$asiento->sector_id] ?? null,
                ];
            });

        return response()->json([
            'data' => $asientos,
        ]);
    }

    /**
     * Obtener asientos de un sector específico para un evento
     */
    public function porSector($eventoId, $sectorId)
    {
        $evento = Evento::findOrFail($eventoId);
        $sector = Sector::findOrFail($sectorId);
        
        // Verificar que el sector esté disponible para el evento
        if (!$evento->sectorEstaDisponible($sectorId)) {
            return response()->json([
                'error' => 'El sector no está disponible para este evento',
            ], 400);
        }

        $asientosOcupados = array_fill_keys(
            \App\Models\EstadoAsiento::where('evento_id', $eventoId)->pluck('asiento_id')->toArray(), 
            true
        );

        $asientos = $sector->asientos()
            ->get()
            ->map(function ($asiento) use ($asientosOcupados) {
                return [
                    'id' => $asiento->id,
                    'fila' => $asiento->fila,
                    'numero' => $asiento->numero,
                    'disponible' => !isset($asientosOcupados[$asiento->id]),
                ];
            });

        $precio = $evento->precioDelSector($sectorId);

        return response()->json([
            'data' => [
                'sector' => $sector,
                'precio' => $precio?->precio,
                'asientos' => $asientos,
            ],
        ]);
    }
}