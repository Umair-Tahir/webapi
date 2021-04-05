<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DeliveryTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('delivery_types')->delete();
        
        \DB::table('delivery_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Pick Up',
                'description' => 'Order online and self pick up order from the restaurant.',
                'created_at' => '2020-04-11 15:03:21',
                'updated_at' => '2020-04-11 15:03:21',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Restaurant Delivery',
                'description' => 'Order your food and restaurant will deliver it to you.',
                'created_at' => '2020-04-11 15:03:21',
                'updated_at' => '2020-04-11 15:03:21',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Delivery Partner',
                'description' => 'Order your food and get it delivered by one of our delivery services.',
                'created_at' => '2020-04-11 15:03:21',
                'updated_at' => '2020-04-11 15:03:21',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Food Delivery Partner',
                'description' => 'Order your food and get it delivered by one of our food delivery partners.',
                'created_at' => '2020-04-11 15:03:21',
                'updated_at' => '2020-04-11 15:03:21',
            )
        ));
        
        
    }
}