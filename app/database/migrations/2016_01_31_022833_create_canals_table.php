<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCanalsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->char('codigo', 2)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('encuesta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->text('descripcion');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tipo_pregunta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->text('descripcion');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('region', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('id_pais')->unsigned()->index();
            $table->foreign('id_pais')->references('id')->on('pais')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ciudad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('id_region')->unsigned()->index();
            $table->foreign('id_region')->references('id')->on('region')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('plan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('q_encuestas');
            $table->integer('q_momentos');
            $table->integer('q_usuarios');
            $table->boolean('opt_in');
            $table->boolean('descarga_data');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sector', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->text('descripcion');
            $table->integer('id_encuesta')->unsigned()->index();
            $table->foreign('id_encuesta')->references('id')->on('encuesta')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cuenta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut');
            $table->string('nombre');
            $table->string('nombre_legal');
            $table->string('fono_fijo');
            $table->string('fono_celular');
            $table->string('correo');
            $table->string('codigo_postal');
            $table->string('direccion');
            $table->integer('id_ciudad')->unsigned()->index();
            $table->integer('id_sector')->unsigned()->index();
            $table->integer('id_plan')->unsigned()->index();
            $table->foreign('id_ciudad')->references('id')->on('ciudad')->onDelete('cascade');
            $table->foreign('id_sector')->references('id')->on('sector')->onDelete('cascade');
            $table->foreign('id_plan')->references('id')->on('plan')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('apariencia', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('img_header');
            $table->mediumText('img_incentivo');
            $table->string('colorbg_body');
            $table->string('colorbg_opcion');
            $table->string('colorbg_boton');
            $table->string('colortxt_incentivo');
            $table->string('colortxt_body');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('momento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('numero')->unsigned()->index();
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_canal')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_canal')->references('id')->on('canal')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pregunta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unsigned()->index();
            $table->text('texto1');
            $table->text('texto2');
            $table->text('texto3');
            $table->integer('id_padre');
            $table->integer('id_encuesta')->unsigned()->index();
            $table->integer('id_categoria')->unsigned()->index();
            $table->integer('id_tipo_pregunta')->unsigned()->index();
            $table->foreign('id_encuesta')->references('id')->on('encuesta')->onDelete('cascade');
            $table->foreign('id_categoria')->references('id')->on('categoria')->onDelete('cascade');
            $table->foreign('id_tipo_pregunta')->references('id')->on('tipo_pregunta')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('encuestado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut')->unique();
            $table->string('nombre');
            $table->string('correo');
            $table->timestamp('fecha_nacimiento');
            $table->boolean('desea_correo');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_momento')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_momento')->references('id')->on('momento')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('respuesta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('valor1');
            $table->longText('valor2');
            $table->integer('id_padre');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_encuesta')->unsigned()->index();
            $table->integer('id_pregunta')->unsigned()->index();
            $table->integer('id_momento')->unsigned()->index();
            $table->integer('id_encuestado')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_encuesta')->references('id')->on('encuesta')->onDelete('cascade');
            $table->foreign('id_pregunta')->references('id')->on('pregunta')->onDelete('cascade');
            $table->foreign('id_momento')->references('id')->on('momento')->onDelete('cascade');
            $table->foreign('id_encuestado')->references('id')->on('encuestado')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('respuesta_cuenta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_respuesta')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_respuesta')->references('id')->on('respuesta')->onDelete('cascade');
        });

        Schema::create('periodo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meta');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('nps', function (Blueprint $table) {
            $table->increments('id');
            $table->double('promedio');
            $table->string('clasificacion');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_momento')->unsigned()->index();
            $table->integer('id_encuestado')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_momento')->references('id')->on('momento')->onDelete('cascade');
            $table->foreign('id_encuestado')->references('id')->on('encuestado')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('url', function (Blueprint $table) {
            $table->increments('id');
            $table->string('given');
            $table->longText('url');
            $table->text('params');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_momento')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_momento')->references('id')->on('momento')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('visita', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_momento')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_momento')->references('id')->on('momento')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('perfil', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->text('descripcion');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('acceso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias');
            $table->string('ruta');
            $table->string('accion');
            $table->text('descripcion');
            $table->integer('id_padre')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('permiso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('id_perfil')->unsigned()->index();
            $table->integer('id_acceso')->unsigned()->index();
            $table->foreign('id_perfil')->references('id')->on('perfil')->onDelete('cascade');
            $table->foreign('id_acceso')->references('id')->on('acceso')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('nombre');
            $table->string('correo')->unique();
            $table->string('linkedlin');
            $table->string('rol_organizacion');
            $table->boolean('es_responsable_cuenta');
            $table->integer('id_cuenta')->unsigned()->index();
            $table->integer('id_perfil')->unsigned()->index();
            $table->foreign('id_cuenta')->references('id')->on('cuenta')->onDelete('cascade');
            $table->foreign('id_perfil')->references('id')->on('perfil')->onDelete('cascade');
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password');
            $table->timestamp('fecha_caducidad');
            $table->integer('id_usuario')->unsigned()->index();
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('perfil_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_perfil')->unsigned()->index();
            $table->integer('id_usuario')->unsigned()->index();
            $table->foreign('id_perfil')->references('id')->on('perfil')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('canal');
    }

}
