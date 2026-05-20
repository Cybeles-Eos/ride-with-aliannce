<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeoMetasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('seo_metas')->delete();
        
        \DB::table('seo_metas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'meta_title' => 'Home',
                'meta_keywords' => 'Home',
                'meta_description' => 'Home',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'meta_title' => 'About Us',
                'meta_keywords' => 'About Us',
                'meta_description' => 'About Us',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'meta_title' => 'Contact Us',
                'meta_keywords' => 'Contact Us',
                'meta_description' => 'Contact Us',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'meta_title' => 'Page Not Found',
                'meta_keywords' => 'Page Not Found',
                'meta_description' => 'Page Not Found',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'meta_title' => 'Login',
                'meta_keywords' => 'Login',
                'meta_description' => 'Login',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'meta_title' => 'Register',
                'meta_keywords' => 'Register',
                'meta_description' => 'Register',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'meta_title' => 'Forgot Password',
                'meta_keywords' => 'Forgot Password',
                'meta_description' => 'Forgot Password',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'meta_title' => 'Reset Password',
                'meta_keywords' => 'Reset Password',
                'meta_description' => 'Reset Password',
                'canonical_link' => '',
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}