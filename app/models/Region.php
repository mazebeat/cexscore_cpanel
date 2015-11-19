<?php

/**
 * Region
 *
 * @property integer        $id_region
 * @property string         $descripcion_region
 * @property integer        $id_pais
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Region whereIdRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\Region whereDescripcionRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\Region whereIdPais($value)
 * @method static \Illuminate\Database\Query\Builder|\Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Region whereUpdatedAt($value)
 * @method static \Region byPais($idpais)
 */
class Region extends \Eloquent
{
    public static $rules      = [];
    protected     $table      = 'region';
    protected     $primaryKey = 'id_region';
    protected     $fillable   = array('descripcion_region', 'id_pais');

    public function scopeByPais($query, $idpais)
    {
        return $query->whereIdPais($idpais)->orderBy('descripcion_region');
    }
}