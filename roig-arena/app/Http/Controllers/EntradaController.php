<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntradaResource;
use App\Models\EstadoAsiento;
use App\Models\Entrada;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    /**
     * Listar mis entradas
     */
    public function index(Request $request)
    {
        $entradas = $request->user()
            ->entradas()
            ->with(['evento', 'asiento.sector', 'user'])
            ->latest()
            ->get();

        return response()->json([
            'data' => EntradaResource::collection($entradas),
        ]);
    }

    /**
     * Ver detalle de una entrada
     */
    public function show($id)
    {
        $entrada = Entrada::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['evento', 'asiento.sector'])
            ->firstOrFail();

        return response()->json([
            'data' => $entrada->informacionCompleta(),
        ]);
    }

    /**
     * Cancelar una entrada y liberar el asiento
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $entrada = Entrada::where('id', $id)
                ->where('user_id', auth()->id())
                ->with(['evento', 'asiento'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($entrada->evento->yaPaso()) {
                throw new \Exception('No se puede cancelar una entrada de un evento pasado');
            }

            EstadoAsiento::where('evento_id', $entrada->evento_id)
                ->where('asiento_id', $entrada->asiento_id)
                ->where('estado', 'vendido')
                ->delete();

            $entrada->delete();

            DB::commit();

            return response()->json([
                'message' => 'Entrada cancelada y asiento liberado correctamente',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}