<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_medicamentos', function (Blueprint $table) {
			$table->id();
			$table->date('fecha_ingreso');
			$table->text('descripcion');
			$table->boolean('estado')->default(1);
			$table->foreignId('user_id')->constrained();
			$table->foreignId('proveedor_id')->constrained();
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
        Schema::dropIfExists('ingreso_medicamentos');
    }
}
