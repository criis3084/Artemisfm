<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Rol;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstNameMale,
        'apellidos' => $faker->lastName,
        'CUI' => $faker->numberBetween($min = 10000000000000, $max = 99999999999999),
        'genero' => $faker->numberBetween($min = 0, $max = 1),
        'numero_telefono' => $faker->numberBetween($min = 11111111, $max = 99999999),
        'correo' => $faker->email,
        'direccion' => $faker->address,
        'fecha_nacimiento' => $faker-> date($format = 'Y-m-d', $max = 'now'),
        'imagen_perfil' => $faker->text($maxNbChars = 100), 
        'descripcion' => $faker->text($maxNbChars = 200), 
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'user'=> $faker->userName,
        'password'=> $faker->password,
        'rol_id' => Rol::pluck('id')[$faker->numberBetween(1,Rol::count()-1)],
        //'rol_id' => factory(App\Rol::class),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
