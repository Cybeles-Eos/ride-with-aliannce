<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTemplateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_template_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_template_id')->constrained()->onDelete('cascade');
            $table->foreignId('field_type_id')->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('alias', 255);
            $table->string('label', 255)->nullable();
            $table->string('placeholder', 255)->nullable();
            $table->text('help_text')->nullable();
            $table->boolean('is_required')->default(false);
            $table->json('validation_rules')->nullable();
            $table->json('settings')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['section_template_id', 'sort_order']);
            $table->index('alias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_template_fields');
    }
}
