<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class Cliente extends \Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    public static $rules = [
        'create' => [
            'rut_cliente'          => 'required|unique:cliente',
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
        ],
        'update' => [
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
        ],
    ];

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

    public static function clientResumen($id)
    {
        $cliente    = Cliente::find($id);
        $momentos   = array();
        $allMoments = MomentoEncuesta::where('id_encuesta', $cliente->encuesta->id_encuesta)->get();
        foreach ($allMoments as $key => $value) {
            $given = $value->urls()->where('id_cliente', $id)->first();
            if (!is_null($given)) {
                $url = array_add($value->toArray(), 'url', url($given->given));
            } else {
                $url = $value->toArray();
            }
            array_push($momentos, $url);
        }

        return array(
            'cliente'  => $cliente->toArray(),
            'usuarios' => CsUsuario::where('id_cliente', $id)->get()->toArray(),
            'plan'     => $cliente->plan->toArray(),
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

        return [
            //            [
            //                'legenda' => 'total',
            //                'counta'  => (string)$total->count(),
            //            ],
            [
                'legend' => Lang::get('messages.active'),
                'count'  => $count,
            ],
            [

                'legend' => Lang::get('messages.inactive'),
                'count'  => ($total->count() - $count),
            ],
        ];
    }

    /**
     * @return mixed
     */
    public static function clientsByPlan()
    {
        return self::select([DB::raw('COUNT(*) AS count, plan.descripcion_plan as plan')])->join('plan', 'cliente.id_plan', '=', 'plan.id_plan')->groupBy('cliente.id_plan')->get()->toArray();
    }

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
        return $this->hasManyThrough('Momento', 'Encuesta', 'id_momento', 'id_encuesta');
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
    public function theme()
    {
        return $this->apariencias->first();
    }
}