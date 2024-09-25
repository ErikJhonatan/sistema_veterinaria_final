<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\PermisoRol;
use Illuminate\Http\Request;

class PermisoRolController extends Controller
{

    public function save(Request $request){

        $this->validate($request, [
            "permiso_id" => "required|exists:permisos,id",
            "rol_id" => "required|exists:roles,id"
        ]);

        if(!PermisoRol::where("permiso_id", $request->permiso_id)
                    ->where("rol_id", $request->rol_id)
                    ->first()){
            $permisoRol = PermisoRol::create([
                "permiso_id" => $request->permiso_id,
                "rol_id" => $request->rol_id
            ]);
        }
        

        return response()->json($permisoRol);
    }

    public function delete($rolId, $permisoId){
        
        $permisoRol = PermisoRol::where("rol_id", $rolId)
                                ->where("permiso_id" , $permisoId)
                                ->first();

        if(!$permisoRol){
            return response()->json(["message" => "PermisoRol no encontrado"], 404);
        }

        $permisoRol->delete();
        return response()->json($permisoRol);

    }
}
