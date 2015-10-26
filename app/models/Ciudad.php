<?php

/**
 * Ciudad
 *
 * @property integer $id_ciudad 
 * @property integer $id_region 
 * @property string $descripcion_ciudad 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\Ciudad whereIdCiudad($value)
 * @method static \Illuminate\Database\Query\Builder|\Ciudad whereIdRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\Ciudad whereDescripcionCiudad($value)
 * @method static \Illuminate\Database\Query\Builder|\Ciudad whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ciudad whereUpdatedAt($value)
 * @method static \Ciudad byRegion($idregion)
 */
class Ciudad extends \Eloquent
{
    public static $rules      = array('descripcion_ciudad' => 'required', 'id_region' => '');
    protected     $table      = 'ciudad';
    protected     $primaryKey = 'id_ciudad';
    protected     $fillable   = array('descripcion_ciudad', 'id_region');

    public function scopeByRegion($query, $idregion)
    {
        return $query->whereIdRegion($idregion)->orderBy('descripcion_ciudad');
    }
}