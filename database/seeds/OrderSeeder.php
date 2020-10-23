<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the Order database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = factory('App\Order', 10)->create();
    }
}
