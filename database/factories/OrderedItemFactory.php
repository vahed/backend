<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\OrderedItem::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween(1, 10),
        'total' => $faker->numberBetween(1, 100),
        'order_date' => now(),
    ];
});
