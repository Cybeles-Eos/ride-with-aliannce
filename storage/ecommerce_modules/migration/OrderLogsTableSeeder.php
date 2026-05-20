<?php

use Illuminate\Database\Seeder;

class OrderLogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_logs')->delete();
        
        
        
    }
}