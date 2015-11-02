<?php

/**
 * Usuario
 *
 * @property integer        $id_usuario
 * @property string         $nombre_usuario
 * @property string         $password
 * @property string         $fecha_nacimiento
 * @property integer        $edad_usuario
 * @property string         $genero_usuario
 * @property string         $correo_usuario
 * @property string         $rut_usuario
 * @property string         $desea_correo_usuario
 * @property integer        $id_tipo_usuario
 * @property integer        $id_cliente
 * @property string         $id_encuesta
 * @property string         $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereIdUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereNombreUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereEdadUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereGeneroUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereCorreoUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereRutUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereDeseaCorreoUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereIdTipoUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Usuario whereUpdatedAt($value)
 */
class Usuario extends \Eloquent
{

    public static $rules      = array(
        'username'             => 'required',
        'nombre_usuario'       => 'required',
        'password'             => 'required',
        'edad_usuario'         => 'required',
        'fecha_nacimiento'     => 'required',
        'genero_usuario'       => 'required',
        'correo_usuario'       => 'required',
        'rut_usuario'          => 'required',
        'desea_correo_usuario' => 'required',
        'id_tipo_usuario'      => 'required',
        'id_cliente'           => 'required',
        'id_encuesta'          => 'required',
    );
    protected     $table      = 'usuario';
    protected     $primaryKey = 'id_usuario';
    protected     $hidden     = array(
        'password',
        'remember_token',
    );
    protected     $guard      = array(
        'password',
        'remember_token',
    );
    protected     $fillable   = array(
        'username',
        'password',
        'nombre_usuario',
        'fecha_nacimiento',
        'edad_usuario',
        'genero_usuario',
        'correo_usuario',
        'linkedlin_usuario',
        'rut_usuario',
        'desea_correo_usuario',
        'responsable_usuario',
        'rol_organizacion_usuario',
        'id_tipo_usuario',
        'id_cliente',
        'id_encuesta',
    );

    public function cliente()
    {
        return $this->belongsTo('Cliente', 'id_cliente');
    }

}