<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Home',
                'slug' => 'home',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 1,
                'page_type_id' => 1,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'About Us',
                'slug' => 'about-us',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 2,
                'page_type_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 3,
                'page_type_id' => 3,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Page Not Found',
                'slug' => '404',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 4,
                'page_type_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Login',
                'slug' => 'customer/login',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 5,
                'page_type_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Register',
                'slug' => 'customer/register',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 6,
                'page_type_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Forgot Password',
                'slug' => 'customer/password/email',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 7,
                'page_type_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Reset Password',
                'slug' => 'customer/password/reset',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 8,
                'page_type_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}