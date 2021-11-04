<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class produccionController extends Controller
{
    //
    public function obtenerProgramacion()
    {
        $programacion = DB::select('SELECT * FROM produccion WHERE estatus = 1');
        return $programacion;
    }

    public function ciclaProgramacion(Request $req)
    {
        // return ($req->programacion[0]['depto']['id']);
        for ($i = 0; $i < count($req->programacion); $i++):
            $id_produccion = $this->agregarProgramacion($req, $req->programacion[$i]['depto']['id'], $req->programacion[$i]['sucursal']['id']);
            $this->agregarPrimerMov($req->programacion[$i], $id_produccion, $req->id_producto, $req->creacion);
        endfor;
        return response("Se programó correctamente", 200);
    }

    public function agregarProgramacion($data, $id_depto, $id_sucursal)
    {
        // !    EL REQUEST CONTIENE UN ARRAY DE OBJETOS LLAMADO PROGRAMACION "$req -> programacion"
        // ! 1. CREO EL REGISTRO PARA LA PRODUCCION
        // return $item['sucursal'];
        // return $item['sucursal'] -> id;
        // return 'Sucursal: ' + $item['sucursal']['id'];
        $agregarProg = DB::table('produccion')->insertGetId(
            [
                'id_det_ot' => $data['id_det_ot'],             //! 2 RECUPERO id_det_ot del data
                'id_producto' => $data['id_producto'],         //! 2 RECUPERO id_producto del data
                'cant_sol' => $data['cant_sol'],               //! 2 RECUPERO cant_sol del data
                'urgencia' => $data['urgencia'],               //! 2 RECUPERO urgencia del data
                'fecha_entrega' => $data['fecha_entrega'],     //! 2 RECUPERO fecha_entrega del data
                'id_creador' => $data['id_creador'],           //! 2 RECUPERO id_creador del data
                'creacion' => $data['creacion'],               //! 2 RECUPERO creacion del data
                'tipo_prog' => $data['tipo_prog'],             //! 2 RECUPERO tipo
                'cant_prog' => $data['cant_prog'],
                'id_depto' => $id_depto,
                'id_sucursal' => $id_sucursal
            ]
        );
        return $agregarProg;
    }

    public function agregarPrimerMov($item, $id_produccion, $id_producto, $creacion)
    {
        $agregar = DB::table('movim_prod')->insertGetId(
            [
                'id_produccion' => $id_produccion,
                'id_depto' => $item['depto']['id'],
                'id_sucursal' => $item['sucursal']['id'],
                'id_producto' => $id_producto,
                'cant_sol' => $item['cantidad'],
                'creacion' => $creacion
            ]
        );
    }

    public function obtenerMovimProd()
    {
        $produccion = DB::select('SELECT * FROM movim_prod WHERE estatus = 1');
        return $produccion;
    }

    public function actualizarMovimProd($id, Request $req)
    {
        $actualizar = DB::update('UPDATE movim_prod
                                    SET
                                            id_produccion=:id_produccion,       id_depto=:id_depto,
                                            id_sucursal=:id_sucursal,           id_producto=:id_producto,
                                            cant_sol=:cant_sol,                 recibidas=:recibidas,
                                            terminadas=:terminadas,             creacion=:creacion,
                                            estatus_prod=:estatus_prod,         estatus=:estatus
                                    WHERE   id=:id',
            [
                'id_produccion' => $req->id_produccion,
                'id_depto' => $req->id_depto,
                'id_sucursal' => $req->id_sucursal,
                'id_producto' => $req->id_producto,
                'cant_sol' => $req->cant_sol,
                'recibidas' => $req->recibidas,
                'terminadas' => $req->terminadas,
                'creacion' => $req->creacion,
                'estatus_prod' => $req->estatus_prod,
                'estatus' => $req->estatus,
                'id' => $req->id
            ]);
        if ($actualizar):
            return response("Se actualizo el registro de movimiento de produccion correctamente", 200);
        else:
            return response("Ocurrio un problema al actualizar el registro de movimiento de produccion, por favor intentelo mas tarde.", 500);
        endif;
    }
}
