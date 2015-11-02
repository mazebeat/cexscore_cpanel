<?php

class Periodo extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'id_periodo' => 'required',
		'periodo' => 'required',
		'meta' => 'required',
		'mes' => 'required',
		'anio' => 'required',
		'id_cliente' => 'required'
	);
}
