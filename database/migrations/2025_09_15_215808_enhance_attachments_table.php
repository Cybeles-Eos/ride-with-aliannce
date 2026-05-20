<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnhanceAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attachments', function (Blueprint $table) {
            // Add new columns (check if they don't already exist)
            if (!Schema::hasColumn('attachments', 'original_name')) {
                $table->string('original_name', 255)->nullable()->after('name');
            }
            if (!Schema::hasColumn('attachments', 'mime_type')) {
                $table->string('mime_type', 100)->nullable()->after('mime');
            }
            if (!Schema::hasColumn('attachments', 'size')) {
                $table->bigInteger('size')->nullable()->after('mime_type');
            }
            if (!Schema::hasColumn('attachments', 'path')) {
                $table->string('path', 500)->nullable()->after('size');
            }
            if (!Schema::hasColumn('attachments', 'url')) {
                $table->string('url', 500)->nullable()->after('path');
            }
            if (!Schema::hasColumn('attachments', 'alt_text')) {
                $table->string('alt_text', 255)->nullable()->after('url');
            }
            if (!Schema::hasColumn('attachments', 'title')) {
                $table->string('title', 255)->nullable()->after('alt_text');
            }
            if (!Schema::hasColumn('attachments', 'caption')) {
                $table->text('caption')->nullable()->after('title');
            }
            if (!Schema::hasColumn('attachments', 'disk')) {
                $table->string('disk', 50)->default('public')->after('folder');
            }
            if (!Schema::hasColumn('attachments', 'metadata')) {
                $table->json('metadata')->nullable()->after('disk');
            }
            if (!Schema::hasColumn('attachments', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('metadata');
            }
            if (!Schema::hasColumn('attachments', 'uploaded_by')) {
                $table->integer('uploaded_by')->unsigned()->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('attachments', 'usage_count')) {
                $table->integer('usage_count')->default(0)->after('uploaded_by');
            }
            if (!Schema::hasColumn('attachments', 'last_used_at')) {
                $table->timestamp('last_used_at')->nullable()->after('usage_count');
            }
        });
        
        // Add foreign key and indexes after the columns are created
        $foreignKeys = DB::select("SHOW CREATE TABLE attachments")[0]->{'Create Table'};
        if (!str_contains($foreignKeys, 'attachments_uploaded_by_foreign')) {
            Schema::table('attachments', function (Blueprint $table) {
                $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
            });
        }
        
        // Add indexes if they don't exist
        $indexes = [
            'attachments_mime_type_index' => 'mime_type',
            'attachments_is_active_index' => 'is_active',
            'attachments_usage_count_index' => 'usage_count'
        ];
        
        foreach ($indexes as $indexName => $column) {
            $indexExists = DB::select("SHOW INDEX FROM attachments WHERE Key_name = '{$indexName}'");
            if (empty($indexExists)) {
                Schema::table('attachments', function (Blueprint $table) use ($column) {
                    $table->index($column);
                });
            }
        }
        
        // Add composite index
        $compositeIndexExists = DB::select("SHOW INDEX FROM attachments WHERE Key_name = 'attachments_folder_is_active_index'");
        if (empty($compositeIndexExists)) {
            Schema::table('attachments', function (Blueprint $table) {
                $table->index(['folder', 'is_active']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropIndex(['attachments_mime_type_index']);
            $table->dropIndex(['attachments_is_active_index']);
            $table->dropIndex(['attachments_folder_is_active_index']);
            $table->dropIndex(['attachments_usage_count_index']);
            
            $table->dropColumn([
                'original_name', 'mime_type', 'size', 'path', 'url', 'alt_text', 'title', 
                'caption', 'disk', 'metadata', 'is_active', 'uploaded_by', 
                'usage_count', 'last_used_at'
            ]);
        });
    }
}
