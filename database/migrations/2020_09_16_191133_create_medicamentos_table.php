<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamentos', function (Blueprint $table) {
			$table->id();
			$table->string('nombre',50);
			$table->string('descripcion');
			$table->integer('stock_general');
			$table->boolean('estado')->default(1);
			$table->foreignId('categoria_medicamento_id')->constrained();			
			$table->foreignId('casa_medica_id')->constrained();
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
        Schema::dropIfExists('medicamentos');
    }
}
