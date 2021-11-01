<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Administrativo;
use App\User;
use Faker\Generator as Faker;

$factory->define(Administrativo::class, function (Faker $faker) {
    return [
        
        'descripcion_puesto' => $faker->text($maxNbChars = 100),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        // 'vivienda_id' => Vivienda::pluck('id')[$faker->numberBetween(1,Vivienda::count()-1)],
        'user_id' => factory(App\User::class),
        // 'user_id' => User::pluck('id')[$faker->numberBetween(1,User::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
