<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'column_id' => $faker->randomNumber(),
        'dashboard_id' => $faker->randomNumber(),
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'archived' => $faker->boolean,
        'sort' => $faker->randomNumber(),
    ];
});
