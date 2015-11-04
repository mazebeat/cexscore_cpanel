<?php

/**
 * Momento
 *
 * @property integer $id_momento 
 * @property string $descripcion_momento 
 * @property integer $id_estado 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\Momento whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereDescripcionMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereUpdatedAt($value)
 */
class Momento extends \Eloquent
{

    public static $rules      = ['descripcion_momento' => 'required', 'id_estado' => 'required'];
    protected     $table      = 'momento';
    protected     $primaryKey = 'id_momento';
    protected     $fillable   = array(
        'descripcion_momento',
        'medicion',
        'id_estado',
    );

    public function encuestas()
    {
        return $this->belongsToMany('Encuesta', 'momento_encuesta', 'id_momento', 'id_encuesta')->withPivot('descripcion_momento');
//        return $this->hasManyThrough('Encuesta', 'MomentoEncuesta', 'id_momento', 'id_encuesta');
    }

}