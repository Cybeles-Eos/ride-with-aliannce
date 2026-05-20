<?php

use Illuminate\Database\Seeder;

class CouponCodesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('coupon_codes')->delete();
        
        \DB::table('coupon_codes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'code' => 'TEST_COUPON_PERCENTAGE',
                'value' => '10.00',
                'type' => 1,
                'date_start' => '2019-07-11 00:00:00',
                'date_end' => '2019-07-31 00:00:00',
                'created_at' => '2019-07-11 16:54:37',
                'updated_at' => '2019-07-11 16:54:37',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 2,
                'code' => 'TEST_COUPON_AMOUNT',
                'value' => '50.00',
                'type' => 2,
                'date_start' => '2019-07-11 00:00:00',
                'date_end' => '2019-07-31 00:00:00',
                'created_at' => '2019-07-11 16:57:37',
                'updated_at' => '2019-07-11 16:57:37',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}