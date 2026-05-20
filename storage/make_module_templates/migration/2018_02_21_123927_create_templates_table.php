<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateCamelCasePluralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_snake_case_plural', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->text('slug');
            $table->string('banner_image', 255);
            $table->string('file', 255);
            $table->text('content');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_snake_case_plural');
    }
}