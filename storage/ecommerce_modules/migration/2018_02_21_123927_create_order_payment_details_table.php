<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderPaymentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_payment_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id');
			$table->string('first_name', 125);
			$table->string('last_name', 125);
			$table->string('transaction_id', 250);
			$table->string('gateway', 250);
			$table->decimal('total_amount', 10, 2);
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
		Schema::drop('order_payment_details');
	}

}
