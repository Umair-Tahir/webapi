<?php

use Illuminate\Database\Seeder;

class OrderStatusesUpdateTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        


        
        \DB::table('order_statuses')->insert(array (
            array (
                'id' => 6,
                'status' => 'Pending',
                'created_at' => '2019-10-15 18:04:30',
                'updated_at' => '2019-10-15 18:04:30',
            ),
            array (
                'id' => 7,
                'status' => 'Cancelled',
                'created_at' => '2019-10-15 18:04:30',
                'updated_at' => '2019-10-15 18:04:30',
            ),
        ));
        
        
    }
}