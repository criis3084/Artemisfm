<?php

use Illuminate\Database\Seeder;

class DetalleSalidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DetalleSalida::class, 25)->create();
    }
}
