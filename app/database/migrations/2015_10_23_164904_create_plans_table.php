<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plans', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('id_plan');
			$table->string('descripcion_plan');
			$table->integer('cantidad_encuestas_plan');
			$table->integer('cantidad_usuarios_plan');
			$table->integer('cantidad_momentos_plan');
			$table->integer('optin_plan');
			$table->integer('descarga_datos_plan');
			$table->integer('id_estado');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plans');
	}

}
