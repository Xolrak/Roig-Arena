<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntradaResource;
use App\Models\Entrada;
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
}