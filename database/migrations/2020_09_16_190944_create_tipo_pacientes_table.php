<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTipoPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_pacientes', function (Blueprint $table) {
			$table->id();
			$table->string('nombre',50);
			$table->string('descripcion');
			$table->boolean('estado')->default(1);
			$table->timestamps();
        });
		DB::table('tipo_pacientes')->insert(array('nombre'=>'Externo','descripcion'=>'Paciente que no se encuentra en ningún programa de ARTEMIS'));
		DB::table('tipo_pacientes')->insert(array('nombre'=>'Común','descripcion'=>'Paciente común'));
		DB::table('tipo_pacientes')->insert(array('nombre'=>'Paciente en estado de desnutrición','descripcion'=>'Paciente que pertenece al programa de desnutrición'));
		DB::table('tipo_pacientes')->insert(array('nombre'=>'Por embarazo','descripcion'=>'Pertenecen al programa de control prenatal'));
		DB::table('tipo_pacientes')->insert(array('nombre'=>'Por diabetes','descripcion'=>'Pertenecen al programa de diabetes'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_pacientes');
    }
}
