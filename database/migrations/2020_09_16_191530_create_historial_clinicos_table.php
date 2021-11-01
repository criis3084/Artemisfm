<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialClinicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_clinicos', function (Blueprint $table) {
			$table->id();
			$table->date('fecha_consulta');
			$table->string('descripcion');
			$table->float('peso_actual',5,2)->nullable();
			$table->float('glicemia',5,2)->nullable();
			$table->integer('semanas_embarazo')->nullable();
			$table->float('talla',5,2)->nullable();
			$table->integer('pulso')->nullable();
			$table->integer('respiracion')->nullable();
			$table->float('temperatura',5,2)->nullable();
			$table->string('presion_arterial',9)->nullable();
			$table->text('objetivo');
			$table->text('subjetivo');
			$table->foreignId('clinico_id')->constrained();
			$table->foreignId('paciente_id')->constrained();
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
        Schema::dropIfExists('historial_clinicos');
    }
}
