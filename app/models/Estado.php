<?php

/**
 * Estado
 *
 * @property integer $id_estado 
 * @property string $tipo_estado 
 * @property string $descripcion_estado 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\Estado whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Estado whereTipoEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Estado whereDescripcionEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Estado whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Estado whereUpdatedAt($value)
 */
class Estado extends \Eloquent
{
    public static $rules      = array(
        'tipo_estado'        => 'required',
        'descripcion_estado' => 'required',
    );
    protected     $table      = 'estado';
    protected     $primaryKey = 'id_estado';
    protected     $fillable   = array(
        'tipo_estado',
        'descripcion_estado',
    );

}