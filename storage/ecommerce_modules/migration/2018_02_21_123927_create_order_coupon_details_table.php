<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderCouponDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_coupon_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id');
            $table->integer('coupon_id');
            $table->string('coupon_code', 125);
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
		Schema::drop('order_coupon_details');
	}

}
