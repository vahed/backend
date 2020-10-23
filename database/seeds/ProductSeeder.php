<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the Product database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = factory('App\Product', 10)->create();
    }
}
