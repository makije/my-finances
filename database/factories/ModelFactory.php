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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'currency' => $faker->word,
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
        'account_id' => factory(App\Account::class)->create()->id,
        'statement' => $faker->sentence,
        'amount' => $faker->randomNumber(),
        'balance' => $faker->randomNumber(),
        'executed' => \Carbon\Carbon::now(),
        'rate' => \Carbon\Carbon::now(),
    ];
});
