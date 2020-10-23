<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'order_number' => function() {
            return factory(\App\OrderedItem::class)->create()->id;
        },
        'customer_number' => function() {
            return factory(\App\Customer::class)->create()->id;
        },
        'product_number' => function() {
            return factory(\App\Product::class)->create()->id;
        }
    ];
});
