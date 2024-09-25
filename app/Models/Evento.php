<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getTipoEvento(){
        return $this->belongsTo(TipoEvento::class,'idTipoEvento','id');
    }

    public function getEstadoEvento(){
        return $this->belongsTo(EstadoEvento::class,'idEstadoEvento','id');
    }

    public function getNotificacion(){
        return $this->belongsTo(Notificacion::class,'idNotificacion','id');
    }

    public function getCliente(){
        return $this->belongsTo(Cliente::class,'idCliente','id');
    }

    public function getMascota(){
        return $this->belongsTo(Mascota::class,'idMascota','id');
    }
    public function getUsuario(){
        return $this->belongsTo(User::class,'idUsuario','id');
    }
}
