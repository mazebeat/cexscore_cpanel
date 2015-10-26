<?php

/**
 * Visita
 *
 * @property integer $id_visita 
 * @property integer $id_cliente 
 * @property integer $id_canal 
 * @property integer $id_momento 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\Visita whereIdVisita($value)
 * @method static \Illuminate\Database\Query\Builder|\Visita whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Visita whereIdCanal($value)
 * @method static \Illuminate\Database\Query\Builder|\Visita whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Visita whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Visita whereUpdatedAt($value)
 */
class Visita extends Eloquent
{
    public static $rules      = array('id_cliente' => 'required', 'id_canal' => 'required', 'momento' => 'required');
    protected     $table      = 'visita';
    protected     $primaryKey = 'id_visita';
    protected     $fillable   = array('id_cliente', 'id_canal', 'momento');
}