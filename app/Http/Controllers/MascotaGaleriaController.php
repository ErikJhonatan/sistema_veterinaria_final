<?php

namespace App\Http\Controllers;

use App\Http\Requests\MascotaGaleria\SaveMascotaGaleriaRequest;
use App\Models\MascotaGaleria;
use Illuminate\Http\Request;

class MascotaGaleriaController extends Controller
{
    public function findAll(Request $request) {
        $mascotaGaleria = MascotaGaleria::where('mascota_id', $request->mascota_id)->get();
        return $mascotaGaleria;
    }

    public function store(SaveMascotaGaleriaRequest $request) {
        $galeria = $request->file('galeria');
        $archivos = [];
        foreach($galeria as $archivo){
            $mascotaGaleria = new MascotaGaleria();
            $mascotaGaleria->mascota_id = $request->mascota_id;
            $path = $this->guardarGaleria($archivo, $request->mascota_id);
            $mascotaGaleria->path = $path;
            $mascotaGaleria->save();
            $archivos[] = $mascotaGaleria;
        }

        return $archivos;
    }

    public function guardarGaleria($archivo, $idMascota){
        $nombreArchivo = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME).'_'.$idMascota.'.'.$archivo->getClientOriginalExtension();
        $path = $archivo->storeAs('mascota_galeria', $nombreArchivo, 'public');
        return $path;
    }

    public function delete(int $id) {
        $mascotaGaleria = MascotaGaleria::find($id);
        $mascotaGaleria->delete();
        return response()->json(['message' => 'Galeria eliminada correctamente'], 200);
    }
}
