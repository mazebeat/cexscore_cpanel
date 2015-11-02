<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class Cliente extends \Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    public static $rules = array(
        'rut_cliente'          => 'required|unique:cliente',
        'nombre_cliente'       => 'required',
        'nombre_legal_cliente' => 'required',
        'fono_fijo_cliente'    => 'required',
        'fono_celular_cliente' => 'required',
        'correo_cliente'       => 'required|email',
        'direccion_cliente'    => 'required',
        'informacion_cliente'  => 'required',
        'desea_correo_cliente' => 'required',
        'id_estado'            => 'required',
        'id_ciudad'            => 'required',
        'id_tipo_cliente'      => 'required',
        'id_sector'            => 'required',
        'id_apariencia'        => 'required',
        'id_plan'              => 'required',
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
        'informacion_cliente',
        'desea_correo_cliente',
        'id_estado',
        'id_ciudad',
        'id_tipo_cliente',
        'id_sector',
        'id_apariencia',
        'id_plan',
    );

    public static function clientResumen($id)
    {
        $cliente = Cliente::find($id);
        $resumen = array(
            'cliente'  => $cliente->toArray(),
            'usuarios' => CsUsuario::where('id_cliente', $id)->get()->toArray(),
            'plan'     => $cliente->plan->toArray(),
            'sector'   => $cliente->sector->toArray(),
            'momentos' => MomentoEncuesta::where('id_encuesta', $cliente->encuesta->id_encuesta)->get()->toArray());
        //
        //        $resumen = array_merge(['cliente' => $cliente->toArray()], ['plan' => $plans], ['sector' => $sector], ['usuarios' => $usuarios]);

        //        $resumen = array_merge(['cliente' => $cliente->toArray()], ['usuarios' => $usuarios]);

        return $resumen;
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