<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Http\Services\PermisoService;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{

    public function index(Request $request){
        
        $permisos = PermisoService::permisosRol($request->user()->rol_id);

        return view('roles.index');
    }
    
    public function findAll(Request $request){
        $roles = Rol::with([
            'permisos' => function($query){
                $query->select('permisos.id');
            }
            ])->get();
        $roles = $roles->map(function($rol){
            return [
                "id" => $rol->id,
                "nombre" => $rol->nombre,
                "permisos" => $rol->permisos->pluck('id')
            ];
        });
        

        return response()->json($roles);
    }
}
