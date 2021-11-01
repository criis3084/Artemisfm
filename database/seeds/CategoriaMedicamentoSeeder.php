<?php

use Illuminate\Database\Seeder;

class CategoriaMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CategoriaMedicamento::class, 50)->create();
    }
}
