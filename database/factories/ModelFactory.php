<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\TroubleTicket::class, function (Faker\Generator $faker) {


    $index = array_rand(App\Utilities\Company::all());
    $company = App\Utilities\Company::find($index);
    return [
        'title' => $faker->word,
        'user_id' => 1,
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'website' => $company,
        'complete' => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});
