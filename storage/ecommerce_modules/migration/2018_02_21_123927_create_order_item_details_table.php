<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderItemDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_item_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id');
            $table->string('name', 255);
            $table->string('product_unit', 255);
            $table->string('quantity', 255);
			$table->decimal('price', 10, 2);
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
		Schema::drop('order_item_details');
	}

}
