<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_versions', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id')->unsigned();
            $table->integer('section_id')->unsigned()->nullable();
            $table->integer('version_number');
            $table->longText('content');
            $table->text('changes_summary')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamp('created_at');
            
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['page_id', 'version_number']);
            $table->index(['section_id', 'version_number']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_versions');
    }
}
