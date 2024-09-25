<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\SaveProductoGaleriaRequest;
use App\Models\ProductoGaleria;
use Illuminate\Http\Request;

class ProductoGaleriaController extends Controller
{
    public function findAll(Request $request) {
        $productoGaleria = ProductoGaleria::where('producto_id', $request->producto_id)->get();
        return $productoGaleria;
    }

    public function store(SaveProductoGaleriaRequest $request) {
        $galeria = $request->file('galeria');
        $archivos = [];
        foreach($galeria as $archivo){
            $productoGaleria = new ProductoGaleria();
            $productoGaleria->producto_id = $request->producto_id;
            $path = $this->guardarGaleria($archivo, $request->producto_id);
            $productoGaleria->path = $path;
            $productoGaleria->save();
            $archivos[] = $productoGaleria;
        }

        return $archivos;
    }

    public function guardarGaleria($archivo, $idProducto){
        $nombreArchivo = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME).'_'.$idProducto.$archivo->getClientOriginalExtension();
        $path = $archivo->storeAs('producto_galeria', $nombreArchivo, 'public');
        return $path;
    }

    public function delete(int $id) {
        $productoGaleria = ProductoGaleria::find($id);
        $productoGaleria->delete();
        return response()->json(['message' => 'Galeria eliminada correctamente'], 200);
    }
}
