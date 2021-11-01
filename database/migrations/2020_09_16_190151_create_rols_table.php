<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rols', function (Blueprint $table) {
			$table->id();
			$table->string('nombre',20);
			$table->boolean('estado')->default(1);
			$table->timestamps();
		});
		//1 = Director(a)
		//2 = Secretario(a)
		//3 = Farmaceutico(a)
		DB::table('rols')->insert(array('nombre'=>'Directora'));
		DB::table('rols')->insert(array('nombre'=>'Secretaria'));
		DB::table('rols')->insert(array('nombre'=>'Farmaceutica'));
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rols');
    }
}
