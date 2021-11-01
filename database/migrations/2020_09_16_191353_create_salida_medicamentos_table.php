<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_medicamentos', function (Blueprint $table) {
			$table->id();
			$table->date('fecha_salida');
			$table->text('descripcion');
			$table->boolean('tipo_salida')->default(0);
			$table->boolean('estado')->default(1);
			$table->foreignId('user_id')->constrained();
			$table->foreignId('paciente_id')->constrained();
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
        Schema::dropIfExists('salida_medicamentos');
    }
}
