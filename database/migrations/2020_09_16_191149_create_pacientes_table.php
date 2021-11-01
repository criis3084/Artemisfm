<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
			$table->id();
			$table->tinyInteger('dia_apoyo')->nullable();			
			$table->foreignId('persona_sin_acceso_id')->constrained();
			$table->foreignId('tipo_paciente_id')->constrained();
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
        Schema::dropIfExists('pacientes');
    }
}
