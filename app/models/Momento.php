<?php

/**
 * Momento
 *
 * @property integer                                                   $id_momento
 * @property string                                                    $descripcion_momento
 * @property integer                                                   $id_estado
 * @property \Carbon\Carbon                                            $created_at
 * @property \Carbon\Carbon                                            $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encuesta[] $encuestas
 * @method static \Illuminate\Database\Query\Builder|\Momento whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereDescripcionMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Momento whereUpdatedAt($value)
 */
class Momento extends \Eloquent
{

    public static $rules      = array('descripcion_momento' => 'required', 'id_estado' => 'required');
    protected     $table      = 'momento';
    protected     $primaryKey = 'id_momento';
    protected     $fillable   = array(
        'descripcion_momento',
        'medicion',
        'id_estado',
    );

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($moment) {
            Log::warning('Eliminando Momento ' . $moment->id_momento);
        });
    }

    public function encuestas()
    {
        return $this->belongsToMany('Encuesta', 'momento_encuesta', 'id_momento', 'id_encuesta')->withPivot('descripcion_momento');
    }
}