<?php

use Illuminate\Database\Seeder;

class PersonaSinAccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PersonaSinAcceso::class, 300)->create();
    }
}
