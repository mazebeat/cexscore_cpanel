<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('id_usuario');
			$table->string('usuario');
			$table->string('password');
			$table->string('nombre_usuario');
			$table->string('fecha_nacimiento');
			$table->integer('edad_usuario');
			$table->string('genero_usuario');
			$table->string('correo_usuario');
			$table->string('linkedlin_usuario');
			$table->string('rut_usuario');
			$table->string('desea_correo_usuario');
			$table->string('responsable_usuario');
			$table->integer('rol_organizacion_usuario');
			$table->integer('id_tipo_usuario');
			$table->integer('id_cliente');
			$table->integer('id_encuesta');
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
		Schema::drop('usuarios');
	}

}
