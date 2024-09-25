<?php

namespace App\Http\Services;

use App\Models\Movimiento;

class MovimientoService {

    public function findAll(array $request){
        if(!isset($request["modulo"])){
            return response()->json(["error" => "El modulo es requerido"]);
        }
        $modulo = $request["modulo"];
        $movimientos = Movimiento::where("modulo", $modulo)
                        ->with([
                            "tipoMovimiento",
                            "usuario"
                        ])
                        ->when(isset($request["fecha_desde"]), function($query) use ($request){
                            $query->whereDate("created_at", ">=", $request["fecha_desde"]);
                        })
                        ->when(isset($request["fecha_hasta"]), function($query) use ($request){
                            $query->whereDate("created_at", "<=", $request["fecha_hasta"]);
                        })
                        ->when(isset($request["usuario_id"]), function($query) use ($request){
                            $query->where("usuario_id", $request["usuario_id"]);
                        })
                        ->orderBy("created_at", "desc")
                        ->get();

        return $movimientos;
    }

    public function create(array $data, $esEliminacion = false){
        $this->validarCamposYDevolverError($data, $esEliminacion);
        $movimiento = new Movimiento();
        $movimiento->tipo_movimiento_id = $data['tipo_movimiento_id'];
        $movimiento->modulo = $data['modulo'];
        if ($esEliminacion) {
            // Para eliminaciones, solo se guarda el valor anterior y se especifica el tipo de movimiento adecuado
            $movimiento->valor_anterior = $data['valor_anterior'];
            $movimiento->valor_nuevo = null; // No hay valor nuevo en una eliminación
        } else {
            $movimiento->valor_nuevo = $this->obtenerDiferenciaValorNuevo($data['valor_anterior'], $data['valor_nuevo']);
            $movimiento->valor_anterior = $this->obtenerDiferenciaValorAnterior($data['valor_anterior'], $data['valor_nuevo']);
        }
        $movimiento->usuario_id = $data['usuario_id'];
       
        $movimiento->save();
    
        return $movimiento;
    }

    private function validarCamposYDevolverError(array $data, $esEliminacion = false){
        if(!isset($data['modulo'])){
            throw new \Exception('El campo modulo es requerido');
        }
        if(!isset($data['tipo_movimiento_id'])){
        throw new \Exception('El campo tipo_movimiento_id es requerido');
        }
        if(!$esEliminacion && !isset($data['valor_nuevo'])){
            throw new \Exception('El campo valor_nuevo es requerido');
        }
        if(!isset($data['usuario_id'])){
            throw new \Exception('El campo usuario_id es requerido');
        }
    }


    private function obtenerDiferenciaValorAnterior($valorAnterior, $valorNuevo){
        $diferencias = [];
        $valorAnterior = json_decode($valorAnterior, true);
        $valorNuevo = json_decode($valorNuevo, true);
        if(!$valorAnterior){
            return null;
        }
        foreach($valorAnterior as $key => $value){
            if($valorAnterior[$key] != $valorNuevo[$key] && $key !== "updated_at"){
                $diferencias[$key] = $valorAnterior[$key];
            }
        }
        return json_encode($diferencias);
    }

    private function obtenerDiferenciaValorNuevo($valorAnterior, $valorNuevo){
        $diferencias = [];
        $valorAnterior = json_decode($valorAnterior, true);
        $valorNuevo = json_decode($valorNuevo, true);

        if(!$valorAnterior){
            foreach($valorNuevo as $key => $value){
                if($valorNuevo[$key] && $key !== "updated_at" && $key !== "created_at"){
                    $diferencias[$key] = $valorNuevo[$key];
                }
            }
        } else {

            foreach($valorNuevo as $key => $value){
                if($valorAnterior && $valorAnterior[$key] != $valorNuevo[$key] && $key !== "updated_at"){
                    $diferencias[$key] = $valorNuevo[$key];
                }
            }
        }
        return json_encode($diferencias);
    }
}