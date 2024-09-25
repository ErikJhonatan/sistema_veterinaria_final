<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function findAll(Request $request){
            
        $permisos = Permiso::orderBy("nombre")->get();

        return response()->json($permisos);
    }
}
