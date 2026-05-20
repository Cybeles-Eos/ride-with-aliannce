<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('system_settings')->delete();
        
        \DB::table('system_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'SS0001',
                'name' => 'Website Name',
                'value' => 'Monte Carlo Web Graphics Studio',
                'type' => 'input',
                'created_at' => '2018-03-01 13:14:05',
                'updated_at' => '2018-03-01 13:14:05',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'SS0002',
                'name' => 'Website Email',
                'value' => 'test1@dogandrooster.net',
                'type' => 'input',
                'created_at' => '2018-03-01 13:14:05',
                'updated_at' => '2018-03-01 13:14:05',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'SS0003',
                'name' => 'Website Phone',
                'value' => '858 677 9931',
                'type' => 'input',
                'created_at' => '2018-03-01 13:14:05',
                'updated_at' => '2018-03-01 13:14:05',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'SS0004',
                'name' => 'Website Address',
                'value' => '5755 Oberlin Dr #106, San Diego, CA 92121, USA',
                'type' => 'textarea',
                'created_at' => '2018-03-01 13:14:05',
                'updated_at' => '2018-03-01 13:14:05',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'SS0005',
                'name' => 'Default Meta Title',
                'value' => 'Default Meta Title',
                'type' => 'input',
                'created_at' => '2018-03-01 13:14:05',
                'updated_at' => '2018-03-01 13:14:05',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'SS0006',
                'name' => 'Default Meta Keywords',
                'value' => 'Default Meta Keywords',
                'type' => 'input',
                'created_at' => '2018-03-01 13:14:05',
                'updated_at' => '2018-03-01 13:14:05',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'SS0007',
                'name' => 'Default Meta Description',
            'value' => 'Monte Carlo Web Graphics Studio Website. ACL Integrated (Access Control List).',
                'type' => 'textarea',
                'created_at' => '2018-03-01 13:14:05',
                'updated_at' => '2018-03-01 13:14:05',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}