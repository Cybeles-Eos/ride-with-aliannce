<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PageSectionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('page_section')->delete();
        
        \DB::table('page_section')->insert(array ());
        
        
    }
}