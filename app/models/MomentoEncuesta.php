<?php

/**
 * MomentoEncuesta
 *
 * @property integer $id_momento_encuesta 
 * @property integer $id_momento 
 * @property integer $id_encuesta 
 * @property integer $id_cliente 
 * @property string $descripcion_momento 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Url[] $urls 
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereIdMomentoEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\MomentoEncuesta whereIdCliente($value)
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

    public function urls()
    {
        return $this->hasMany('Url', 'id_momento', 'id_momento');
    }


}
