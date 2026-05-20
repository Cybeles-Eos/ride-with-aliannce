<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTaxDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_tax_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id');
            $table->decimal('tax_percentage', 10, 4);
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
		Schema::drop('order_tax_details');
	}

}
