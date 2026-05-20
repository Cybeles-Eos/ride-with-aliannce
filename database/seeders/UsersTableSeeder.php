<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'email' => 'info+super_admin@montecarlowebgraphics.com',
                    'user_name' => 'super_admin',
                    'password' => bcrypt('P@ssword1'),
                    'first_name' => 'Super',
                    'middle_name' => '',
                    'last_name' => 'Admin',
                    'is_active' => 1,
                    'last_login' => '2018-03-01 13:33:36',
                    'token' => NULL,
                    'remember_token' => NULL,
                    'created_at' => '2018-03-01 13:14:04',
                    'updated_at' => '2018-03-01 13:38:29',
                    'deleted_at' => NULL,
                ),
            1 =>
                array (
                    'id' => 2,
                    'email' => 'test1@dogandrooster.net',
                    'user_name' => 'webmaster',
                    'password' => bcrypt('P@ssword1'),
                    'first_name' => 'Webmaster',
                    'middle_name' => '',
                    'last_name' => 'Webmaster',
                    'is_active' => 1,
                    'last_login' => '2018-03-01 13:33:36',
                    'token' => NULL,
                    'remember_token' => NULL,
                    'created_at' => '2018-03-01 13:14:04',
                    'updated_at' => '2018-03-01 13:38:29',
                    'deleted_at' => NULL,
                ),
            2 =>
                array (
                    'id' => 3,
                    'email' => 'info+customer_user@montecarlowebgraphics.com',
                    'user_name' => 'customer_user',
                    'password' =>  bcrypt('P@ssword1'),
                    'first_name' => 'Customer',
                    'middle_name' => '',
                    'last_name' => 'One',
                    'is_active' => 1,
                    'last_login' => '2018-03-01 13:14:05',
                    'token' => NULL,
                    'remember_token' => NULL,
                    'created_at' => '2018-03-01 13:14:05',
                    'updated_at' => '2018-03-01 14:04:25',
                    'deleted_at' => NULL,
                ),
        ));


    }
}