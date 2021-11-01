<?php

use Illuminate\Database\Seeder;

class TipoPacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TipoPaciente::class, 5)->create();
    }
}
