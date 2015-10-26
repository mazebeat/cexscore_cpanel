<?php

/**
 * TipoCliente
 *
 */
class TipoCliente extends \Eloquent
{
    public static $rules      = [];
    protected     $table      = 'tipo_cliente';
    protected     $primaryKey = 'id_tipo_cliente';
    protected     $fillable   = array('descripcion_tipo_cliente');

}