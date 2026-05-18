<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Listar eventos futuros (público)
     */
    public function index()
    {
        $eventos = Evento::futuros()
            ->with(['precios.sector'])
            ->get();

        return response()->json([
            'data' => $eventos,
        ]);
    }

    /**
     * Ver detalle de un evento (público)
     */
    public function show($id)
    {
        $evento = Evento::with(['precios.sector'])
            ->findOrFail($id);

        return response()->json([
            'data' => array_merge($evento->toArray(), [
                'sectores_disponibles' => $evento->sectoresDisponibles(),
                'asientos_disponibles' => $evento->totalAsientosDisponibles(),
                'entradas_vendidas' => $evento->totalEntradasVendidas(),
            ]),
        ]);
    }

    /**
     * Crear evento (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'descripcion_corta' => 'nullable|string|max:255',
            'descripcion_larga' => 'nullable|string',
            'poster_url' => 'nullable|url',
            'fecha' => 'required|date|unique:eventos,fecha',
            'hora' => 'required|string',
        ]);

        $data = $this->normalizarDescripcionEvento($request);
        $evento = Evento::create($data);

        return response()->json([
            'data' => $evento,
            'message' => 'Evento creado correctamente',
        ], 201);
    }

    /**
     * Actualizar evento (admin)
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'descripcion_corta' => 'nullable|string|max:255',
            'descripcion_larga' => 'nullable|string',
            'poster_url' => 'nullable|url',
            'fecha' => 'sometimes|date|unique:eventos,fecha,' . $id,
            'hora' => 'sometimes|string',
        ]);

        $evento->update($this->normalizarDescripcionEvento($request));

        return response()->json([
            'data' => $evento,
            'message' => 'Evento actualizado correctamente',
        ]);
    }

    /**
     * Eliminar evento (admin)
     */
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        
        // Verificar que no tenga entradas vendidas
        if ($evento->totalEntradasVendidas() > 0) {
            return response()->json([
                'error' => 'No se puede eliminar un evento con entradas vendidas',
            ], 400);
        }

        $evento->delete();

        return response()->json([
            'message' => 'Evento eliminado correctamente',
        ]);
    }

    private function normalizarDescripcionEvento(Request $request): array
    {
        $data = $request->only([
            'nombre',
            'descripcion_corta',
            'descripcion_larga',
            'poster_url',
            'fecha',
            'hora',
        ]);

        if ($request->filled('descripcion') && ! $request->filled('descripcion_corta') && ! $request->filled('descripcion_larga')) {
            $data['descripcion_corta'] = $request->descripcion;
            $data['descripcion_larga'] = $request->descripcion;
        }

        if ($request->filled('hora')) {
            $data['hora'] = \Carbon\Carbon::parse($request->hora)->format('H:i');
        }

        return $data;
    }
}