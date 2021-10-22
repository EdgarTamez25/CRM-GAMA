<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\clientes;
use App\prospectos;

class clientesController extends Controller
{
    /** @return \Illuminate\Http\Response */
		
		public function clientes(){
			$clientes = DB::select('SELECT id, nombre, estatus FROM clientes');
			return $clientes ? $clientes:[];
		}

    public function catClientes(){
        $data = DB::select('SELECT c.id , c.nombre, c.direccion, c.id_ciudad, cty.nombre as ciudad,
																	 e.nombre as estado, c.cp, p.nombre as pais, c.id_zona, z.nombre as nomzona, 
<<<<<<< HEAD
																	 c.razon_social, c.fuente, c.tipo_cliente, c.rfc,
																	 c.nivel, c.tel1, c.ext1, c.tel2, c.ext2, c.contacto, 
																	 c.contacto2,c.estatus,c.diasfact
														FROM clientes c LEFT JOIN zonas 		z  ON c.id_zona = z.id
=======
																	 c.razon_social, c.fuente, c.tipo_cliente, c.rfc,c.id_cartera, 
																	 c.nivel, ca.nombre as nomcartera, c.tel1, c.ext1, c.tel2, c.ext2, c.contacto, 
																	 c.contacto2,c.estatus,c.diasfact
														FROM clientes c LEFT JOIN zonas 		z  ON c.id_zona = z.id
																						LEFT JOIN carteras ca  ON c.id_cartera = ca.id 
>>>>>>> AE
																						LEFT JOIN ciudades cty ON c.id_ciudad = cty.id 
																						LEFT JOIN estados e    ON cty.id_estado = e.id
																						LEFT JOIN paises p     ON e.id_pais = p.id
														WHERE c.prospecto = 0');
        return $data;
		}
		
		public function clientesSelector(){
			return DB::select('SELECT c.id, c.nombre FROM  clientes c WHERE c.estatus = 1');
		}

    public function add(Request $request){
			// $addcliente = clientes::create($request->all());

			$addcliente = DB::table('clientes')->insertGetId(
			[
					'nombre' 	      => $request -> nombre,
					'direccion'     => $request -> direccion,
					'id_ciudad'     => $request -> id_ciudad,
					'cp'    				=> $request -> cp,
					'id_zona'			  => $request -> id_zona,
					'tipo_cliente' 	=> $request -> tipo_cliente,
					'rfc'			      => $request -> rfc,
					'id_cartera'		=> $request -> id_cartera,
					'fuente' 				=> $request -> fuente,
					'nivel' 	      => $request -> nivel,
					'razon_social'  => $request -> razon_social,
					'tel1' 			    => $request -> tel1,
					'ext1' 			    => $request -> ext1,
					'tel2' 			    => $request -> tel2,
					'ext2' 			    => $request -> ext2,
					'contacto' 		  => $request -> contacto,
					'contacto2' 	  => $request -> contacto2,
					'diasfact' 	    => $request -> diasfact,
					'estatus'       => $request -> estatus,
					'prospecto'     => $request -> prospecto
			]);

			
			if($addcliente):
				return "El Cliente se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear el cliente, por favor intentelo mas tarde.";
			endif;

    }

    public function update($id, Request $req){
				$data = DB::update('UPDATE clientes SET nombre=:nombre, direccion=:direccion, id_zona=:id_zona,tipo_cliente=:tipo_cliente,
<<<<<<< HEAD
																								rfc=:rfc,razon_social=:razon_social, nivel=:nivel,
=======
																								rfc=:rfc, id_cartera=:id_cartera, razon_social=:razon_social, nivel=:nivel,
>>>>>>> AE
																								fuente=:fuente, tel1=:tel1, ext1=:ext1, tel2=:tel2, ext2=:ext2, contacto=:contacto,	
																								contacto2=:contacto2,	diasfact=:diasfact, prospecto=:prospecto, id_ciudad=:id_ciudad,
																								cp=:cp
															WHERE id=:id'
														,['nombre'				=> $req -> nombre,  		 'direccion'    => $req -> direccion,
															'id_zona'       => $req -> id_zona, 		 'tipo_cliente'	=> $req	-> tipo_cliente, 
															'rfc'						=> $req	-> rfc,     		 
															'razon_social'	=> $req	-> razon_social, 'nivel'		   	=> $req	-> nivel, 
															'fuente'				=> $req	-> fuente,       'tel1'					=> $req -> tel1,
															'ext1'    			=> $req -> ext1,				 'tel2'					=> $req -> tel2,         
															'ext2'					=> $req -> ext2,		     'contacto'			=> $req -> contacto,
															'contacto2'			=> $req -> contacto2,    'diasfact'			=> $req -> diasfact,     
															'prospecto'     => $req -> prospecto,		 'id_ciudad'    => $req -> id_ciudad,
															'cp'    			  => $req -> cp,  	 			 'id'						=> $id
														]
													);
				
				return 'El cliente se actualizo correctamente';
		}
		
		public function cambiaEstatus( Request $req){
			return DB::update('UPDATE clientes SET estatus=:estatus WHERE id=:id',['estatus' => $req-> estatus, 'id' => $req -> id]);
		}

		// public function EliminarProspecto($id){
		// 	$EliminaProspecto = prospectos::findOrFail($id);
		// 	prospectos::findOrFail($id)->delete();
		// 	return "El cliente se creo correctamente.";
		// }

}
