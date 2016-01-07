<?php

/**
 * Sector
 *
 * @property integer                                                   $id_sector
 * @property string                                                    $descripcion_sector
 * @property \Carbon\Carbon                                            $created_at
 * @property \Carbon\Carbon                                            $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cliente[]  $clientes
 * @property-read \Encuesta                                            $encuesta
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encuesta[] $encuestas
 * @method static \Illuminate\Database\Query\Builder|\Sector whereIdSector($value)
 * @method static \Illuminate\Database\Query\Builder|\Sector whereDescripcionSector($value)
 * @method static \Illuminate\Database\Query\Builder|\Sector whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sector whereUpdatedAt($value)
 */
class Sector extends \Eloquent
{

    public static $rules      = array(
        'descripcion_sector' => 'required',
    );
    protected     $table      = 'sector';
    protected     $primaryKey = 'id_sector';
    protected     $fillable   = array('descripcion_sector');

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($sector) {
            Log::warning('Eliminado sector ' . $sector->id_sector);
            $sector->encuestas()->delete();
        });
    }

    public function clientes()
    {
        return $this->hasMany('Cliente', 'id_sector');
    }

    public function encuesta()
    {
        return $this->belongsTo('Encuesta', 'encuesta_sector', 'id_sector', 'id_encuesta');
    }

    public function encuestas()
    {
        return $this->belongsToMany('Encuesta', 'encuesta_sector', 'id_sector', 'id_encuesta');
    }
}