<?php

/**
 * ClienteRespuesta
 *
 * @property integer $id_cliente_respuesta
 * @property string $ultima_respuesta
 * @property integer $id_cliente
 * @property integer $id_respuesta
 * @property integer $id_estado
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\ClienteRespuesta whereIdClienteRespuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\ClienteRespuesta whereUltimaRespuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\ClienteRespuesta whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\ClienteRespuesta whereIdRespuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\ClienteRespuesta whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\ClienteRespuesta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ClienteRespuesta whereUpdatedAt($value)
 */
class ClienteRespuesta extends \Eloquent
{

    public static $rules      = [];
    protected     $table      = 'cliente_respuesta';
    protected     $primaryKey = 'id_cliente_respuesta';
    protected     $fillable   = array(
        'id_cliente',
        'ultima_respuesta',
        'id_respuesta',
        'id_estado',
    );

    public static function hasRequests()
    {
        if (!Auth::guest()) {
            $count = static::whereIdCliente(array(Auth::user()->id_cliente))->whereRaw('MONTH(ultima_respuesta) = MONTH(CURRENT_DATE) AND YEAR(ultima_respuesta) = YEAR(CURRENT_DATE)')->orderBy('id_cliente_respuesta',
                'DESC')->count(array('id_cliente'));
            if ($count) {
                return true;
            }
        }

        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!Auth::guest() && Session::get('ya_respondio', false)) {
                static::whereIdCliente(array(Auth::user()->id_cliente))->whereRaw('MONTH(ultima_respuesta) = MONTH(CURRENT_DATE) AND YEAR(ultima_respuesta) = YEAR(CURRENT_DATE)')->whereIdEstado(15)->update(array('id_estado' => 16));
            }
        });
    }
}
