<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Application;
use Faker\Generator as Faker;

$factory->define(
    Application::class, static function (Faker $faker) {
    return [
        'app_name' => $faker->unique()->name
    ];
});
