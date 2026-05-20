<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Create Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Read Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Update Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Delete Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Create Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Read Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Update Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Delete Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Create Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Read Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Update Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Delete Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Create User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Read User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Update User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Delete User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Create System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Read System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Update System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Delete System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Create Page',
                'guard_name' => 'web',
                'permission_group_id' => 6,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Read Page',
                'guard_name' => 'web',
                'permission_group_id' => 6,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Update Page',
                'guard_name' => 'web',
                'permission_group_id' => 6,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Delete Page',
                'guard_name' => 'web',
                'permission_group_id' => 6,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Create Home Slide',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Read Home Slide',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Update Home Slide',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Delete Home Slide',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Create Contact',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Read Contact',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Update Contact',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Delete Contact',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            32 =>
            array (
                'id' => 33,
                'name' => 'Create Product',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Read Product',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Update Product',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Delete Product',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            36 =>
            array (
                'id' => 37,
                'name' => 'Create Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Read Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Update Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Delete Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            40 =>
            array (
                'id' => 41,
                'name' => 'Create Section Template',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            41 =>
            array (
                'id' => 42,
                'name' => 'Read Section Template',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            42 =>
            array (
                'id' => 43,
                'name' => 'Update Section Template',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
            43 =>
            array (
                'id' => 44,
                'name' => 'Delete Section Template',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2019-10-04 22:04:34',
                'updated_at' => '2019-10-04 22:04:34',
            ),
        ));
        
        
    }
}