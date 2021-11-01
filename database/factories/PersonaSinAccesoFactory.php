<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PersonaSinAcceso;
use App\Sector;
use Faker\Generator as Faker;

$factory->define(PersonaSinAcceso::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstNameMale,
        'apellidos' => $faker->lastName,
        'CUI' => $faker->numberBetween($min = 10000000000000, $max = 99999999999999),
        'genero' => $faker->numberBetween($min = 0, $max = 1),
        'fecha_nacimiento' => $faker-> date($format = 'Y-m-d', $max = 'now'),
        'direccion' => $faker->address,
        'numero_telefono' => $faker->numberBetween($min = 11111111, $max = 99999999),
        // 'sector_id' => $faker->numberBetween($min = 1, $max = 10),
        //'sector_id' => Sector::pluck('id')[$faker->numberBetween(1,Sector::count()-1)],
        // 'aldea_id' => function (array $post) {
        //     return App\Sector::find($post['aldea_id'])->type;
        // },
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
