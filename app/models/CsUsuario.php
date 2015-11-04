<?php

class CsUsuario extends \Eloquent
{

    public static $rules      = array(
        'id_perfil'      => '',
        'usuario'        => 'required',
        'pwdusuario'     => 'required',
        'nombre'         => '',
        'email'          => '',
        'activo'         => '',
        'fecha_registro' => '',
        'id_cliente'     => 'required',
    );
    public        $timestamps = false;
    protected     $table      = 'cs_usuarios';
    protected     $primaryKey = 'id_usuario';
    protected     $hidden     = array(
        'pwdusuario',
    );
    protected     $guard      = array(
        'id_usuario',
        'pwdusuario',
    );
    protected     $fillable   = array(
        'id_usuario',
        'id_perfil',
        'usuario',
        'pwdusuario',
        'nombre',
        'email',
        'activo',
        'fecha_registro',
        'id_cliente',
    );

    public function resetPassword()
    {
        $this->pwdusuario = 'e10adc3949ba59abbe56e057f20f883e'; // 123456

        return $this->save();
    }

    public function cliente()
    {
        $this->belongsTo('Cliente', 'id_cliente');
    }
}