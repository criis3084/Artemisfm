<?php

use Illuminate\Database\Seeder;

class IngresoMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\IngresoMedicamento::class, 40)->create();
    }
}
