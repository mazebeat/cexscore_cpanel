<?php

class Periodo extends Eloquent
{
    public static $rules      = array(
        'id_periodo' => '',
        'periodo'    => 'required',
        'meta'       => 'required',
        'mes'        => 'required',
        'anio'       => 'required',
        'id_cliente' => 'required',
    );
    public        $timestamps = false;
    protected     $guarded    = array();
    protected     $table      = 'cs_periodos';
    protected     $primaryKey = 'id_periodo';
}
