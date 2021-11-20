<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'question'    => $faker->sentence,
        'is_answered' => Question::NOT_ANSWERD,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
