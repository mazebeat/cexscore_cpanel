<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

/**
 * Cliente
 *
 * @property integer                                                     $id_cliente
 * @property string                                                      $rut_cliente
 * @property string                                                      $nombre_cliente
 * @property string                                                      $nombre_legal_cliente
 * @property string                                                      $fono_fijo_cliente
 * @property string                                                      $fono_celular_cliente
 * @property string                                                      $correo_cliente
 * @property string                                                      $codigo_postal_cliente
 * @property string                                                      $direccion_cliente
 * @property integer                                                     $id_ciudad
 * @property integer                                                     $id_sector
 * @property integer                                                     $id_plan
 * @property integer                                                     $id_encuesta
 * @property integer                                                     $id_estado
 * @property \Carbon\Carbon                                              $created_at
 * @property \Carbon\Carbon                                              $updated_at
 * @property-read mixed                                                  $is_admin
 * @property-read \Encuesta                                              $encuesta
 * @property-read \Illuminate\Database\Eloquent\Collection|\Apariencia[] $apariencias
 * @property-read \Sector                                                $sector
 * @property-read \Plan                                                  $plan
 * @property-read \Illuminate\Database\Eloquent\Collection|\Respuesta[]  $respuestas
 * @property-read \Illuminate\Database\Eloquent\Collection|\Usuario[]    $usuarios
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereRutCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereNombreCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereNombreLegalCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereFonoFijoCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereFonoCelularCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereCorreoCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereCodigoPostalCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereDireccionCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereIdCiudad($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereIdSector($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereIdPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereIdEncuesta($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereIdEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Cliente whereUpdatedAt($value)
 */
class Cliente extends \Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    public static $rules = array(
        'create' => array(
            'rut_cliente'          => 'required|unique:cliente',
            'nombre_cliente'       => 'required',
            'nombre_legal_cliente' => '',
            'rut_cliente'          => 'required',
            'fono_fijo_cliente'    => '',
            'fono_celular_cliente' => '',
            'correo_cliente'       => 'required|email',
            'direccion_cliente'    => '',
            'id_estado'            => 'required',
            'id_ciudad'            => '',
            'id_sector'            => 'required',
            'id_encuesta'          => 'required',
            'id_plan'              => 'required',
        ),
        'update' => array(
            'rut_cliente'          => 'required',
            'nombre_cliente'       => 'required',
            'nombre_legal_cliente' => '',
            'fono_fijo_cliente'    => '',
            'fono_celular_cliente' => '',
            'correo_cliente'       => 'required|email',
            'direccion_cliente'    => '',
            'id_estado'            => 'required',
            'id_ciudad'            => '',
            'id_sector'            => 'required',
            'id_encuesta'          => 'required',
            'id_plan'              => 'required',
        ),
    );

    protected $table      = 'cliente';
    protected $primaryKey = 'id_cliente';
    protected $fillable   = array(
        'rut_cliente',
        'nombre_cliente',
        'nombre_legal_cliente',
        'fono_fijo_cliente',
        'fono_celular_cliente',
        'correo_cliente',
        'direccion_cliente',
        'codigo_postal_cliente',
        'id_estado',
        'id_ciudad',
        'id_tipo_cliente',
        'id_sector',
        'id_encuesta',
        'id_plan',
    );


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($cliente) {
            $cliente->urls()->delete();
            $cliente->encuesta->momentos()->detach();
            $cliente->usuarios()->delete();
            $cliente->csusuarios()->delete();
        });
    }

    public static function clientResumen($id)
    {
        $cliente  = Cliente::find($id);
        $momentos = array();

        $allMoments = $cliente->momentos()->get();

        foreach ($allMoments as $key => $value) {
            $given = $value->urls()->where('id_cliente', $id)->first();
            if (!is_null($given)) {
                $url = array_add($value->toArray(), 'url', url($given->given));
            } else {
                $url = $value->toArray();
            }
            array_push($momentos, $url);
        }

        $plan = $cliente->plan->toArray();
        array_get($plan, 'optin_plan') == 0 ? array_set($plan, 'optin_plan', 'No') : array_set($plan, 'optin_plan', 'Sí');
        array_get($plan, 'descarga_datos_plan') == 0 ? array_set($plan, 'descarga_datos_plan', 'No') : array_set($plan, 'descarga_datos_plan', 'Sí');

        return array(
            'cliente'  => $cliente->toArray(),
            'admin'    => CsUsuario::responsable()->where('id_cliente', $id)->first()->toArray(),
            'usuarios' => CsUsuario::where('id_cliente', $id)->get()->toArray(),
            'plan'     => $plan,
            'sector'   => $cliente->sector->toArray(),
            'momentos' => $momentos,
        );
    }

    /**
     * @return array
     */
    public static function countClients()
    {
        $total = self::all();
        $count = 0;

        foreach ($total as $k => $v) {
            $cant = $v->respuestas()->actually()->count();

            if ($cant > 0) {
                $count++;
            }
        }

        return array(
            array(
                'legend' => Lang::get('messages.active'),
                'count'  => $count,
                'color'  => '#0D52D1',
            ),
            array(

                'legend' => Lang::get('messages.inactive'),
                'count'  => ($total->count() - $count),
                'color'  => '#FF6600',
            ),
        );
    }

    /**
     * @return mixed
     */
    public static function clientsByPlan()
    {
        return self::select([DB::raw('COUNT(*) AS count, plan.descripcion_plan as plan')])->join('plan', 'cliente.id_plan', '=', 'plan.id_plan')->groupBy('cliente.id_plan')->get()->toArray();
    }

    /**
     * @param            $action
     * @param array      $merge
     * @param bool|false $id
     *
     * @return array
     */
    public static function rules($action, $merge = [], $id = false)
    {
        $rules = self::$rules[$action];

        if ($id) {
            foreach ($rules as &$rule) {
                $rule = str_replace(':id', $id, $rule);
            }
        }

        return array_merge($rules, $merge);
    }

    /**
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->attributes['id_tipo_usuario'] == 1;
    }

    /**
     * @return mixed
     */
    public function encuesta()
    {
        return $this->belongsTo('Encuesta', 'id_encuesta');
    }

    /**
     * @return mixed
     */
    public function apariencias()
    {
        return $this->belongsToMany('Apariencia', 'cliente_apariencia', 'id_cliente', 'id_apariencia');
    }

    /**
     * @return mixed
     */
    public function sector()
    {
        return $this->belongsTo('Sector', 'id_sector');
    }

    /**
     * @return mixed
     */
    public function plan()
    {
        return $this->belongsTo('Plan', 'id_plan');
    }

    /**
     * @return mixed
     */
    public function respuestas()
    {
        return $this->belongsToMany('Respuesta', 'cliente_respuesta', 'id_cliente', 'id_respuesta');
    }

    /**
     * @return mixed
     */
    public function preguntas()
    {
        return $this->hasManyThrough('Sector', 'Encuesta', 'id_sector', 'id_encuesta');
    }

    /**
     * @return mixed
     */
    public function momentos()
    {
        return $this->hasManyThrough('MomentoEncuesta', 'Cliente', 'id_cliente', 'id_cliente');
    }

    /**
     * @return mixed
     */
    public function usuarios()
    {
        return $this->hasMany('Usuario', 'id_usuario');
    }

    /**
     * @return mixed
     */
    public function csusuarios()
    {
        return $this->hasMany('CsUsuario', 'id_usuario');
    }

    /**
     * @return mixed
     */
    public function urls()
    {
        return $this->hasMany('Url', 'id_cliente');
    }

    public function periodos()
    {
        return $this->belongsToMany('Periodo');
    }

    /**
     * @return mixed
     */
    public function theme()
    {
        return $this->apariencias->first();
    }
}