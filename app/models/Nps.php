<?php

/**
 * Nps
 *
 * @property integer        $id_nps
 * @property integer        $id_cliente
 * @property integer        $id_momento
 * @property string         $fecha
 * @property integer        $id_usuario
 * @property integer        $id_canal
 * @property integer        $id_encuesta
 * @property float          $promedio
 * @property string         $clasificacion
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Nps whereIdNps($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereFecha($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereIdUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereIdCanal($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps wherePromedio($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereClasificacion($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Nps whereUpdatedAt($value)
 */
class Nps extends \Eloquent
{
    public static $rules      = [];
    protected     $table      = 'nps';
    protected     $primaryKey = 'id_nps';
    protected     $fillable   = [
        'id_cliente',
        'id_usuario',
        'id_encuesta',
        'id_momento',
        'id_canal',
        'fecha',
        'promedio',
        'clasificacion',
    ];
}