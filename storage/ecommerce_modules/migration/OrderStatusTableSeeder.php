<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_status')->delete();
        
        \DB::table('order_status')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'OS0001',
                'name' => 'New',
                'created_at' => '2019-07-23 11:07:12',
                'updated_at' => '2019-07-23 11:07:12',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'OS0002',
                'name' => 'Reviewed',
                'created_at' => '2019-07-23 11:07:12',
                'updated_at' => '2019-07-23 11:07:12',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'OS0003',
                'name' => 'Production',
                'created_at' => '2019-07-23 11:07:12',
                'updated_at' => '2019-07-23 11:07:12',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'OS0004',
                'name' => 'Shipped',
                'created_at' => '2019-07-23 11:07:12',
                'updated_at' => '2019-07-23 11:07:12',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'OS0005',
                'name' => 'Closed',
                'created_at' => '2019-07-23 11:07:12',
                'updated_at' => '2019-07-23 11:07:12',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}