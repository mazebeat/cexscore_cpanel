<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class Cliente extends \Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    public static $rules = array(
        'rut_cliente'          => 'required|unique:cliente',
        'nombre_cliente'       => 'required',
        'nombre_legal_cliente' => 'required',
        'fono_fijo_cliente'         => 'required',
        'fono_celular_cliente'         => 'required',
        'correo_cliente'       => 'required|email',
        'direccion_cliente'    => 'required',
        'informacion_cliente'  => 'required',
        'desea_correo_cliente' => 'required',
        'id_estado'            => 'required',
        'id_ciudad'            => 'required',
        'id_tipo_cliente'      => 'required',
        'id_sector'            => 'required',
        'id_apariencia'        => 'required',
        'id_plan'              => 'required',
    );

    protected $table      = 'cliente';
    protected $primaryKey = 'id_cliente';
    protected $fillable   = array(
        'rut_cliente',
        'nombre_cliente',
        'nombre_legal_cliente',
        'fono_fijo_cliente',
        'fono_celular_cliente',
        'correo_cliente',
        'direccion_cliente',
        'informacion_cliente',
        'desea_correo_cliente',
        'id_estado',
        'id_ciudad',
        'id_tipo_cliente',
        'id_sector',
        'id_apariencia',
        'id_plan',
    );

    public function getIsAdminAttribute()
    {
        return $this->attributes['id_tipo_usuario'] == 1;
    }

    public function encuesta()
    {
        return $this->belongsTo('Encuesta', 'id_encuesta');
    }

    public function apariencias()
    {
        return $this->belongsToMany('Apariencia', 'cliente_apariencia', 'id_cliente', 'id_apariencia');
    }

    public function sector()
    {
        return $this->belongsTo('Sector', 'id_sector');
    }

    public function plan()
    {
        return $this->belongsTo('Plan', 'id_plan');
    }

    public function respuestas()
    {
        return $this->belongsToMany('Respuesta', 'cliente_respuesta', 'id_cliente', 'id_respuesta');
    }

    public function preguntas()
    {
        return $this->hasManyThrough('Sector', 'Encuesta', 'id_sector', 'id_encuesta');
    }

    public function usuarios()
    {
        return $this->hasMany('User', 'id_usuario');
    }

    public function theme()
    {
        return $this->apariencias->first();
    }
}
