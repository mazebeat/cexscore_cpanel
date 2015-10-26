<?php

/**
 * MomentoEncuesta
 *
 * @property integer $id_momento 
 * @property integer $id_encuesta 
 * @property string $descripcion_momento 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereDescripcionMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereUpdatedAt($value)
 */
class MomentoEncuesta extends Eloquent
{
    public static $rules      = array(
        'id_momento'          => 'required',
        'id_encuesta'         => 'required',
        'descripcion_momento' => 'required',
    );
    protected     $guarded    = array();
    protected     $table      = 'momento_encuesta';
    protected     $primaryKey = 'id_momento_encuesta';
}
