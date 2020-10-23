<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the Customer database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = factory('App\Customer', 10)->create();
    }
}
