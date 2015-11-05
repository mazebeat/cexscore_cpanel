<?php

/**
 * Link
 *
 */
class Link extends \Eloquent
{

    public static $rules      = array();
    protected     $table      = 'link';
    protected     $primaryKey = 'id_link';
    protected     $fillable   = array(
        'descripcion_link',
        'url_link',
        'url_corta',
        'id_sector',
        'id_canal',
        'id_cliente',
        'id_estado',
    );

}