<?php

/**
 * Periodo
 *
 * @property integer $id_periodo 
 * @property string $periodo 
 * @property integer $meta 
 * @property integer $mes 
 * @property integer $anio 
 * @property integer $id_cliente 
 * @method static \Illuminate\Database\Query\Builder|\Periodo whereIdPeriodo($value)
 * @method static \Illuminate\Database\Query\Builder|\Periodo wherePeriodo($value)
 * @method static \Illuminate\Database\Query\Builder|\Periodo whereMeta($value)
 * @method static \Illuminate\Database\Query\Builder|\Periodo whereMes($value)
 * @method static \Illuminate\Database\Query\Builder|\Periodo whereAnio($value)
 * @method static \Illuminate\Database\Query\Builder|\Periodo whereIdCliente($value)
 */
class Periodo extends Eloquent
{
    public static $rules      = array(
        'id_periodo' => '',
        'periodo'    => 'required',
        'meta'       => 'required',
        'mes'        => 'required',
        'anio'       => 'required',
        'id_cliente' => 'required',
    );
    public        $timestamps = false;
    protected     $guarded    = array();
    protected     $table      = 'cs_periodos';
    protected     $primaryKey = 'id_periodo';
}
