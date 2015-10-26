<?php

/**
 * MomentoSector
 *
 * @property integer $id_momento_sector 
 * @property string $descripcion_momento_sector 
 * @property integer $id_sector 
 * @property integer $id_momento 
 * @property integer $id_estado 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\MomentoSector whereIdMomentoSector($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoSector whereDescripcionMomentoSector($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoSector whereIdSector($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoSector whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoSector whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoSector whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoSector whereUpdatedAt($value)
 */
class MomentoSector extends \Eloquent
{

    public static $rules      = array(// 'title'            => 'required'
    );
    protected     $table      = 'momento_sector';
    protected     $primaryKey = 'id_momento_sector';
    protected     $fillable   = array(
        'id_momento',
        'id_sector',
        'descripcion_momento_sector',
        'id_estado',
    );

}