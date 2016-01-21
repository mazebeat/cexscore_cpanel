<?php

/**
 * CsUsuario
 *
 * @property integer       $id_usuario
 * @property integer       $id_perfil
 * @property string        $usuario
 * @property string        $pwdusuario
 * @property string        $nombre
 * @property string        $email
 * @property integer       $activo
 * @property string        $fecha_registro
 * @property integer       $id_cliente
 * @property-read \Cliente $cliente
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereIdUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereIdPerfil($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario wherePwdusuario($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereActivo($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereFechaRegistro($value)
 * @method static \Illuminate\Database\Query\Builder|\CsUsuario whereIdCliente($value)
 */
class CsUsuario extends \Eloquent
{

    public static $rules                  = array(
        'id_perfil'        => '',
        'usuario'          => 'required',
        'pwdusuario'       => 'required',
        'nombre'           => '',
        'rut'              => 'between:8,12|rut',
        'fecha_nacimiento' => '',
        'edad'             => '',
        'genero'           => '',
        'linkedlin'        => '',
        'email'            => 'email',
        'activo'           => '',
        'fecha_registro'   => '',
        'rol_organizacion' => '',
        'id_cliente'       => 'required',
    );
    public static $rulesChangePasword     = array(
        'pwdusuario'    => 'required|alphaNum',
        'passwordAgain' => 'required|alphaNum|same:pwdusuario',
    );
    public static $messagesChangePassword = array(
        'pwdusuario.required'    => 'La contraseña es requerida',
        'pwdusuario.alphaNum'    => 'La contraseñas deben ser alfanumericas',
        'passwordAgain.required' => 'Debe confirmar la contraseña',
        'passwordAgain.alphaNum' => 'La contraseñas deben ser alfanumericas',
        'passwordAgain.same'     => 'Las contraseñas no concuerdan',
    );
    public        $timestamps             = false;
    protected     $table                  = 'cs_usuarios';
    protected     $primaryKey             = 'id_usuario';
    protected     $hidden                 = array(
        'pwdusuario',
    );
    protected     $guard                  = array(
        'id_usuario',
        'pwdusuario',
    );
    protected     $fillable               = array(
        'id_usuario',
        'id_perfil',
        'usuario',
        'pwdusuario',
        'nombre',
        'email',
        'fecha_nacimiento',
        'edad',
        'genero',
        'activo',
        'linkedlin',
        'fecha_registro',
        'id_cliente',
        'responsable',
        'rol_organizacion',
    );

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($csuser) {
            Log::warning('Eliminando CSUsuario ' . $csuser->id_usuario);
        });
    }

    public function resetPassword()
    {
        $this->pwdusuario = 'e10adc3949ba59abbe56e057f20f883e'; // 123456

        return $this->save();
    }

    public function cliente()
    {
        $this->belongsTo('Cliente', 'id_cliente');
    }

    public function scopeResponsable($query)
    {
        return $query->whereResponsable(1);
    }
}