<?php

namespace App\Http\Controllers;

use App\Models\VentaItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistorialComprasController extends Controller
{
    public function findAll(Request $request){
        if(!$request->mascota_id){
            return response()->json("No se han encontrado", 404);
        }

        $parametros = $request->all();
        $query = VentaItem::query();

        $compras = $query->with([
                        'producto',
                        'servicio',
                        'mascota'
                    ])
                    ->when(isset($parametros["nombre"]), function($query) use ($parametros){
                        $query->whereHas('producto', function($query) use ($parametros){
                            $query->where('Producto', 'like', '%'.$parametros["nombre"].'%');
                        })->orWhereHas('servicio', function($query) use ($parametros){
                            $query->where('Servicio', 'like', '%'.$parametros["nombre"].'%');
                        });
                    })
                    ->where("mascota_id", $parametros["mascota_id"])
                    ->orderBy("created_at", "desc")
                    ->get();


        $compras = $compras->map(function($compra){
           
            $compra->nombre = $compra->producto ? $compra->producto->Producto : $compra->servicio->Servicio;
            $compra->precio = $compra->producto ? $compra->producto->Precio : $compra->servicio->Precio;
            $compra->cantidad = $compra->cantidad;
            $compra->total = $compra->total;

            $compra->created_at_transformado =  Carbon::parse($compra->created_at)
            ->setTimezone(config('app.timezone'))
            ->format('Y-m-d H:i:s');
           
            return $compra;
        });

        
        return response()->json($compras);
        
    }

}
