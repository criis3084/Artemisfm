<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudioSocioeconomicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudio_socioeconomicos', function (Blueprint $table) {
			$table->id();
			$table->date('fecha_boleta')->nullable();
			$table->date('fecha_ingreso')->nullable();
			$table->float('total_ingresos',8,2);
			$table->text('alimentacion');
			$table->integer('situacion_vivienda');
			$table->string('descripcion_costo');
			$table->boolean('luz')->default(0);
			$table->boolean('agua')->default(0);
			$table->boolean('drenaje')->default(0);
			$table->integer('cantidad_cuartos');
			$table->string('bano');
			$table->string('paredes');
			$table->string('techo');
			$table->string('piso');
			$table->text('evaluacion_diagnostico');
			$table->boolean('estado')->default(1);
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
        Schema::dropIfExists('estudio_socioeconomicos');
    }
}
