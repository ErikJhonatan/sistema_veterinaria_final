<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function findAll(Request $request,  string $modulo)
    {

        if(!$modulo){
            return response()->json(["error" => "El modulo es requerido"]);
        }

        $movimientos = Movimiento::where("modulo", $modulo)
                        ->with([
                            "tipoMovimiento",
                            "usuario"
                        ])
                        ->when(isset($request->fecha_desde), function($query) use ($request){
                            $query->whereDate("created_at", ">=", $request->fecha_desde);
                        })
                        ->when(isset($request->fecha_hasta), function($query) use ($request){
                            $query->whereDate("created_at", "<=", $request->fecha_hasta);
                        })
                        ->when(isset($request->usuario_id), function($query) use ($request){
                            $query->where("usuario_id", $request->usuario_id);
                        })
                        ->get();

        return response()->json($movimientos);
    }
}
