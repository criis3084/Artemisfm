<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaSinAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_sin_accesos', function (Blueprint $table) {
			$table->id();
			$table->string('nombres',30);
			$table->string('apellidos',30);
			$table->string('CUI',15)->nullable();
			$table->boolean('genero');
			$table->date('fecha_nacimiento')->nullable();
			$table->string('direccion')->nullable();
			$table->string('numero_telefono',15)->nullable();
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
        Schema::dropIfExists('persona_sin_accesos');
    }
}
