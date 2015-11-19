<?php

/**
 * Categoria
 *
 * @property integer $id_categoria 
 * @property string $descripcion_categoria 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\Categoria whereIdCategoria($value)
 * @method static \Illuminate\Database\Query\Builder|\Categoria whereDescripcionCategoria($value)
 * @method static \Illuminate\Database\Query\Builder|\Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Categoria whereUpdatedAt($value)
 */
class Categoria extends \Eloquent
{
    public static $rules      = array(
        'descripcion_categoria' => 'required'
    );
    protected     $table      = 'categoria';
    protected     $primaryKey = 'id_categoria';
    protected     $fillable   = array('descripcion_categoria');

}