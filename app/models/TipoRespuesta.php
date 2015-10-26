<?php

/**
 * TipoRespuesta
 *
 * @property integer $id_tipo_respuesta 
 * @property string $tipo 
 * @property string $opciones 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\TipoRespuesta whereIdTipoRespuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\TipoRespuesta whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\TipoRespuesta whereOpciones($value)
 * @method static \Illuminate\Database\Query\Builder|\TipoRespuesta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TipoRespuesta whereUpdatedAt($value)
 */
class TipoRespuesta extends \Eloquent
{
    public static $rules      = [];
    protected     $table      = 'tipo_respuesta';
    protected     $primaryKey = 'id_tipo_respuesta';
    protected     $fillable   = array('tipo', 'opciones');
}