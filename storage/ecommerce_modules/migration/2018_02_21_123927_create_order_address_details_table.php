<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderAddressDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_address_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id');
			$table->string('first_name', 125);
			$table->string('last_name', 125);
			$table->string('email', 125);
			$table->string('phone', 16);
			$table->string('ext', 16);
			$table->string('company', 125);
			$table->string('address', 125);
			$table->string('address_2', 125);
			$table->string('city', 125);
			$table->string('state', 125);
			$table->string('zip', 125);
			$table->string('country', 125);
			$table->integer('type')->default(1)->comment('1-Billing, 2-Shipping');
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
		Schema::drop('order_address_details');
	}

}
