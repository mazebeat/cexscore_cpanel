<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

/**
 * User
 *
 * @property integer $id_usuario 
 * @property string $username 
 * @property string $password 
 * @property string $nombre_usuario 
 * @property string $fecha_nacimiento 
 * @property integer $edad_usuario 
 * @property string $genero_usuario 
 * @property string $correo_usuario 
 * @property string $linkedlin_usuario 
 * @property string $rut_usuario 
 * @property string $desea_correo_usuario 
 * @property boolean $responsable_usuario 
 * @property string $rol_organizacion_usuario 
 * @property integer $id_tipo_usuario 
 * @property integer $id_cliente 
 * @property string $id_encuesta 
 * @property string $remember_token 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Cliente $cliente 
 * @method static \Illuminate\Database\Query\Builder|\User whereIdUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereNombreUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEdadUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereGeneroUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCorreoUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLinkedlinUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereRutUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereDeseaCorreoUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereResponsableUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereRolOrganizacionUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereIdTipoUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 */
class User extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;
    public static $rules      = [];
    protected     $table      = 'usuario';
    protected     $primaryKey = 'id_usuario';
    protected     $hidden     = array(
        'password',
        'remember_token',
    );

    /**
     * @return mixed
     */
    public function cliente()
    {
        return $this->belongsTo('Cliente', 'id_cliente');
    }

}
