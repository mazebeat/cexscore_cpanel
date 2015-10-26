<?php

/**
 * EncuestaSector
 *
 * @property integer $id_encuesta_sector 
 * @property integer $id_encuesta 
 * @property integer $id_sector 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\EncuestaSector whereIdEncuestaSector($value)
 * @method static \Illuminate\Database\Query\Builder|\EncuestaSector whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\EncuestaSector whereIdSector($value)
 * @method static \Illuminate\Database\Query\Builder|\EncuestaSector whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\EncuestaSector whereUpdatedAt($value)
 */
class EncuestaSector extends \Eloquent
{
    public static $rules      = array(
        'id_momento' => 'required',
        'id_sector'  => 'required',
    );
    protected     $table      = 'encuesta_sector';
    protected     $primaryKey = 'id_encuesta_sector';
    protected     $fillable   = array(
        'id_momento',
        'id_sector',
    );

}