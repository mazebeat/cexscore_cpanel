<?php

/**
 * Excepcion
 *
 * @property integer $id_excepcion 
 * @property string $descripcion_excepcion 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\Excepcion whereIdExcepcion($value)
 * @method static \Illuminate\Database\Query\Builder|\Excepcion whereDescripcionExcepcion($value)
 * @method static \Illuminate\Database\Query\Builder|\Excepcion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Excepcion whereUpdatedAt($value)
 */
class Excepcion extends \Eloquent
{
    public static $rules      = array();
    protected     $table      = 'excepcion';
    protected     $primaryKey = 'id_excepcion';
    protected     $fillable   = array('descripcion_excepcion');

}