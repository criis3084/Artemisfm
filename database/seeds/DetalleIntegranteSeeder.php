<?php

use Illuminate\Database\Seeder;

class DetalleIntegranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DetalleIntegrante::class, 100)->create();
    }
}
