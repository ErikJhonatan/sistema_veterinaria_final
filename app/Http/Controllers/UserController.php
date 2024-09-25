<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Http\Requests\User\SaveUserRequest;
use App\Http\Services\PermisoService;
use App\Models\Rol;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function findAll(Request $request){
            
        $usuarios = User::with([
            'rol',
            'sede',
        ])
        ->orderBy("users.created_at", "desc")
        ->get();
        return response()->json($usuarios);
    }

    public function index(Request $request){

        PermisoService::autorizadoOrFail(
            PermisosValue::USUARIO_VER_MODULO, 
            PermisoService::permisosRol(Auth::user()->rol_id)
        );
        
        $permisos = PermisoService::permisosRol($request->user()->rol_id);
        return view('usuarios.index', [
            "puede_crear" => PermisoService::autorizado(PermisosValue::USUARIO_CREAR, $permisos),
            "puede_editar" => PermisoService::autorizado(PermisosValue::USUARIO_EDITAR, $permisos),
            "puede_eliminar" => PermisoService::autorizado(PermisosValue::USUARIO_ELIMINAR, $permisos),
            "roles" => Rol::all(),
            "sedes" => Sede::all()
        ]);
    }

    public function store(SaveUserRequest $request){
        
        $usuario = User::create([
            "name"      => $request->name,
            "email"     => $request->email,
            "password"  => bcrypt($request->password),
            "rol_id"    => $request->rol_id,
            "sede_id"   => $request->sede_id
  
        ]);

        return response()->json($usuario);

    }

    public function update(SaveUserRequest $request, $id){
        
        $usuario = User::find($id);

        if(!$usuario){
            return response()->json(["message" => "Usuario no encontrado"], 404);
        }

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        if($request->email != $usuario->email && User::where("email", $request->email)->count() > 0){
            return response()->json(["message" => "El email ya está en uso"], 400);
        }
        if($request->password){
            $usuario->password = bcrypt($request->password);
        }
        $usuario->rol_id = $request->rol_id;
        $usuario->sede_id = $request->sede_id;
        $usuario->save();
        return response()->json($usuario);

    }

    public function delete($id){
        
        $usuario = User::find($id);

        if(!$usuario){
            return response()->json(["message" => "Usuario no encontrado"], 404);
        }

        $usuario->delete();
        return response()->json(["message" => "Usuario eliminado"]);

    }
}
