<?php

/**
 * TipoUsuario
 *
 * @property integer $id_tipo_usuario 
 * @property string $descripcion_tipo_cliente 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\TipoUsuario whereIdTipoUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\TipoUsuario whereDescripcionTipoCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\TipoUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TipoUsuario whereUpdatedAt($value)
 */
class TipoUsuario extends Eloquent
{
    public static $rules      = array(
        'descripcion_tipo_cliente' => 'required',
    );
    protected     $guarded    = array();
    protected     $primaryKey = 'id_tipo_usuario';
    protected     $table      = 'tipo_usuario';
}
