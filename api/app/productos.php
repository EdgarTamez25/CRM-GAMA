<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    protected $table = 'productos';
    protected $fillable = array('codigo','nombre','descripcion','id_linea','tipo_producto','id_proveedor',
                                'id_unidad','obs','foto','estatus');
}
