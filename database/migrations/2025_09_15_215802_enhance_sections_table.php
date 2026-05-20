<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EnhanceSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if columns already exist and only add if needed
        if (!Schema::hasColumn('sections', 'alias')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->string('alias', 255)->nullable()->after('name');
            });
        }
        
        if (!Schema::hasColumn('sections', 'section_template_id')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->bigInteger('section_template_id')->unsigned()->nullable()->after('alias');
            });
        }
        
        if (!Schema::hasColumn('sections', 'settings')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->json('settings')->nullable()->after('value');
            });
        }
        
        if (!Schema::hasColumn('sections', 'is_active')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('settings');
            });
        }
        
        // Check if foreign key and indexes exist before creating them
        $foreignKeys = DB::select("SHOW CREATE TABLE sections")[0]->{'Create Table'};
        
        if (!str_contains($foreignKeys, 'sections_section_template_id_foreign')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->foreign('section_template_id')->references('id')->on('section_templates')->onDelete('set null');
            });
        }
        
        $indexes = DB::select("SHOW INDEX FROM sections WHERE Key_name = 'sections_alias_index'");
        if (empty($indexes)) {
            Schema::table('sections', function (Blueprint $table) {
                $table->index('alias');
            });
        }
        
        $compositeIndex = DB::select("SHOW INDEX FROM sections WHERE Key_name = 'sections_is_active_section_template_id_index'");
        if (empty($compositeIndex)) {
            Schema::table('sections', function (Blueprint $table) {
                $table->index(['is_active', 'section_template_id']);
            });
        }
        
        // Update existing sections to have alias values
        DB::statement("UPDATE sections SET alias = LOWER(REPLACE(name, ' ', '-')) WHERE alias IS NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['section_template_id']);
            $table->dropIndex(['sections_alias_index']);
            $table->dropIndex(['sections_is_active_section_template_id_index']);
            $table->dropColumn(['alias', 'section_template_id', 'settings', 'is_active']);
        });
    }
}
