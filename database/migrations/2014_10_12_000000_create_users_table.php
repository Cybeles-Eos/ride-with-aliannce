<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->string('email', 45)/*->unique()*/;
            $table->string('user_name', 45)/*->unique()*/;
            $table->string('password', 125);
            $table->string('first_name', 25);
            $table->string('middle_name', 25);
            $table->string('last_name', 25);
            $table->string('phone', 250);
            $table->string('profile_image', 250);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('token', 255)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
