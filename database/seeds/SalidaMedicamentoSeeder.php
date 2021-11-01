<?php

use Illuminate\Database\Seeder;

class SalidaMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SalidaMedicamento::class, 50)->create();
    }
}
