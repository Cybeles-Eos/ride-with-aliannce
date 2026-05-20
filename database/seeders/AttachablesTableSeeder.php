<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttachablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attachables')->delete();
        
        
        
    }
}