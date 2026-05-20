<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionGroupsTableSeeder::class);
        $this->call(UserHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(SystemSettingsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PageTypesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
//        $this->call(CitiesTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(ContactsTableSeeder::class);
        $this->call(HomeSlidesTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(SeoMetasTableSeeder::class);
        $this->call(UserHasPermissionsTableSeeder::class);
        $this->call(PageSectionTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(AttachmentsTableSeeder::class);
        $this->call(AttachablesTableSeeder::class);
        
        // CMS Field Types (must be seeded before section templates)
        $this->call(FieldTypesSeeder::class);
    }
}
