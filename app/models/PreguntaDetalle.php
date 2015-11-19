<?php

/**
 * PreguntaDetalle
 *
 * @property integer        $id_pregunta_detalle
 * @property string         $descripcion_pregunta_detalle
 * @property string         $fecha_creacion
 * @property string         $fecha_modificacion
 * @property integer        $id_estado
 * @property integer        $id_encuesta
 * @property integer        $id_pregunta_cabecera
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereIdPreguntaDetalle($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereDescripcionPreguntaDetalle($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereFechaCreacion($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereFechaModificacion($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereIdPreguntaCabecera($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PreguntaDetalle whereUpdatedAt($value)
 */
class PreguntaDetalle extends \Eloquent
{
    public static $rules      = [];
    protected     $table      = 'pregunta_detalle';
    protected     $primaryKey = 'id_pregunta_detalle';
    protected     $fillable   = array(
        'descripcion_pregunta_detalle',
        'fecha_creacion',
        'fecha_modificacion',
        'id_estado',
        'id_encuesta',
        'id_pregunta_cabecera',
    );

}