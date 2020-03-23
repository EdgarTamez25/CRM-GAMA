<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->integer('id_producto');
            $table->integer('id_proveedor');//Cuando el producto es un producto final el proveedor es Gama Etiquetas
            $table->integer('tipo_precio');//campaña, metro uadrado, metro lineal, unidad
            $table->integer('id_moneda');
            $table->float('precio');
            $table->float('costo_prod');
            $table->float('costo_admin');
            $table->integer('pje_adminn');
            $table->float('total');
            $table->integer('predeterminado');
            $table->integer('estatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precios');
    }
}
