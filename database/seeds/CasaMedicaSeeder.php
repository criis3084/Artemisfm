<?php

use Illuminate\Database\Seeder;

class CasaMedicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CasaMedica::class, 10)->create();
    }
}
