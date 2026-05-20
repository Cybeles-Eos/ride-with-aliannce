<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderShippingDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_shipping_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id');
            $table->string('shipping_method', 125);
            $table->string('reference_no', 125);
			$table->decimal('total_amount', 10);
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
		Schema::drop('order_shipping_details');
	}

}
