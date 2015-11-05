<?php

/**
 * ExcepcionUsuario
 *
 * @property integer $id_excepcion_usuario 
 * @property integer $id_excepcion 
 * @property integer $id_usuario 
 * @property string $fecha 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\ExcepcionUsuario whereIdExcepcionUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\ExcepcionUsuario whereIdExcepcion($value)
 * @method static \Illuminate\Database\Query\Builder|\ExcepcionUsuario whereIdUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\ExcepcionUsuario whereFecha($value)
 * @method static \Illuminate\Database\Query\Builder|\ExcepcionUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExcepcionUsuario whereUpdatedAt($value)
 */
class ExcepcionUsuario extends \Eloquent
{

    public static $rules      = array();
    protected     $table      = 'excepcion_usuario';
    protected     $primaryKey = 'id_excepcion_usuario';
    protected     $fillable   = array('id_excepcion', 'id_cliente', 'fecha');

}