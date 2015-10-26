<?php

class Plan extends \Eloquent
{

    public static $rules = [
        'descripcion_plan'        => 'required',
        'cantidad_encuestas_plan' => 'required',
        'cantidad_usuarios_plan'  => 'required',
        'cantidad_momentos_plan'  => 'required',
        'optin_plan'              => 'required',
        'descarga_datos_plan'     => 'required',
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