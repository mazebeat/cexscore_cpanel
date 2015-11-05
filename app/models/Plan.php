<?php

/**
 * Plan
 *
 * @property integer $id_plan 
 * @property string $descripcion_plan 
 * @property integer $cantidad_encuestas_plan 
 * @property integer $cantidad_usuarios_plan 
 * @property integer $cantidad_momentos_plan 
 * @property boolean $optin_plan 
 * @property boolean $descarga_datos_plan 
 * @property integer $id_estado 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cliente[] $clientes 
 * @method static \Illuminate\Database\Query\Builder|\Plan whereIdPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereDescripcionPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereCantidadEncuestasPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereCantidadUsuariosPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereCantidadMomentosPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereOptinPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereDescargaDatosPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Plan whereUpdatedAt($value)
 */
class Plan extends \Eloquent
{

    public static $rules = [
        'descripcion_plan'        => 'required',
        'cantidad_encuestas_plan' => 'required',
        'cantidad_usuarios_plan'  => 'required',
        'cantidad_momentos_plan'  => 'required',
        'optin_plan'              => '',
        'descarga_datos_plan'     => '',
        'id_estado'               => 'required',
    ];
    protected     $table = 'plan';

    // Add your validation rules here
    protected $primaryKey = 'id_plan';

    // Don't forget to fill this array
    protected $fillable = [
        'descripcion_plan',
        'cantidad_encuestas_plan',
        'cantidad_usuarios_plan',
        'cantidad_momentos_plan',
        'optin_plan',
        'descarga_datos_plan',
        'id_estado',
    ];

    public function clientes()
    {
        return $this->hasMany('Cliente', 'id_plan');
    }
}