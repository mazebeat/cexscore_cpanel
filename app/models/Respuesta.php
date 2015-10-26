<?php

/**
 * Respuesta
 *
 * @property integer $id_respuesta 
 * @property integer $id_pregunta_cabecera 
 * @property integer $id_encuesta 
 * @property integer $id_canal 
 * @property integer $id_momento 
 * @property integer $id_cliente 
 * @property integer $id_usuario 
 * @property integer $id_estado 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cliente[] $clientes 
 * @property-read \RespuestaDetalle $detalle 
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdRespuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdPreguntaCabecera($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdCanal($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Respuesta whereUpdatedAt($value)
 */
class Respuesta extends \Eloquent
{
    public static $rules      = [];
    protected     $table      = 'respuesta';
    protected     $primaryKey = 'id_respuesta';
    protected     $fillable   = array(
        'fecha',
        'id_estado',
        'id_canal',
        'id_encuesta',
        'id_pregunta_cabecera',
        'id_pregunta_detalle',
    );

    public function clientes()
    {
        return $this->belongsToMany('Cliente', 'cliente_respuesta', 'id_respuesta', 'id_cliente');
    }

    public function detalle()
    {
        return $this->hasOne('RespuestaDetalle', 'id_respuesta');
    }

}