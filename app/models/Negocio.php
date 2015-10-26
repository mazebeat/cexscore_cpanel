<?php

/**
 * Negocio
 *
 */
class Negocio extends \Eloquent
{
    public static $rules      = array(
        'descripcion_negocio' => 'required',
        'id_estado'           => 'required',
    );
    protected     $table      = 'negocio';
    protected     $primaryKey = 'id_negocio';
    protected     $fillable   = array('descripcion_negocio', 'id_estado');
}