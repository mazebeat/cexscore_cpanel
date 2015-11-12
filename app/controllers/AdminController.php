<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;

class AdminController extends \ApiController
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('csrf');
    }

    /**
     * @param null $id
     *
     * @return string
     */
    public static function npsTable($id = null)
    {
        if (!is_null($id)) {
            $strSQL_NPS       = "SELECT nps.promedio FROM nps WHERE nps.id_cliente = " . $id;
            $strSQL_Lealtad   = "SELECT SUM(CASE WHEN valor2 = 'NO' THEN 1 ELSE 0 END) AS Leal_NO, SUM(CASE WHEN valor2 = 'SI' THEN 1 END) AS Leal_SI FROM (SELECT respuesta.id_cliente, respuesta_detalle.valor2 FROM cliente INNER JOIN cliente_respuesta ON cliente.id_cliente = cliente_respuesta.id_cliente INNER JOIN respuesta ON cliente_respuesta.id_respuesta = respuesta.id_respuesta INNER JOIN respuesta_detalle ON respuesta.id_respuesta = respuesta_detalle.id_respuesta INNER JOIN pregunta_cabecera ON respuesta.id_pregunta_cabecera = pregunta_cabecera.id_pregunta_cabecera INNER JOIN (SELECT cliente_respuesta.id_cliente, MAX(cliente_respuesta.id_cliente_respuesta) AS id_ultima_rpta FROM cliente_respuesta INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente GROUP BY id_cliente) AS Ultima_rpta_x_usuario ON cliente_respuesta.id_cliente = Ultima_rpta_x_usuario.id_cliente WHERE (pregunta_cabecera.numero_pregunta = 4) AND cliente.id_cliente = " . $id . ") AS Datos";
            $strSQL_Preguntas = "SELECT numero_pregunta, SUM(NPS_7) AS NPS_7, SUM(NPS_5) AS NPS_5, SUM(NPS_4) AS NPS_4 FROM (SELECT pregunta_cabecera.numero_pregunta, CASE WHEN respuesta_detalle.valor1 >= 6 THEN 1 ELSE 0 end AS NPS_7, CASE WHEN respuesta_detalle.valor1 < 6 AND respuesta_detalle.valor1 > 4 THEN 1 ELSE 0 end AS NPS_5, CASE WHEN respuesta_detalle.valor1 <= 4 then 1 ELSE 0 end AS NPS_4 FROM respuesta INNER JOIN respuesta_detalle ON respuesta.id_respuesta = respuesta_detalle.id_respuesta INNER JOIN cliente_respuesta ON cliente_respuesta.id_respuesta = respuesta.id_respuesta INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente INNER JOIN pregunta_cabecera ON respuesta.id_pregunta_cabecera = pregunta_cabecera.id_pregunta_cabecera INNER JOIN (SELECT cliente_respuesta.id_cliente, MAX(cliente_respuesta.id_cliente_respuesta) AS id_ultima_rpta FROM cliente_respuesta INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente GROUP BY id_cliente " . ") AS Ultima_rpta_x_usuario ON cliente_respuesta.id_cliente = Ultima_rpta_x_usuario.id_cliente WHERE (pregunta_cabecera.numero_pregunta = 1 OR pregunta_cabecera.numero_pregunta = 2 OR pregunta_cabecera.numero_pregunta = 3) AND cliente.id_cliente = " . $id . " GROUP BY respuesta.id_respuesta " . ") AS Datos_Tmp GROUP BY numero_pregunta ORDER BY numero_pregunta";
        } else {
            $strSQL_NPS       = "SELECT nps.promedio FROM nps";
            $strSQL_Lealtad   = "SELECT SUM(CASE WHEN valor2 = 'NO' THEN 1 ELSE 0 END) AS Leal_NO, SUM(CASE WHEN valor2 = 'SI' THEN 1 END) AS Leal_SI FROM (SELECT respuesta.id_cliente, respuesta_detalle.valor2 FROM cliente INNER JOIN cliente_respuesta ON cliente.id_cliente = cliente_respuesta.id_cliente INNER JOIN respuesta ON cliente_respuesta.id_respuesta = respuesta.id_respuesta INNER JOIN respuesta_detalle ON respuesta.id_respuesta = respuesta_detalle.id_respuesta INNER JOIN pregunta_cabecera ON respuesta.id_pregunta_cabecera = pregunta_cabecera.id_pregunta_cabecera INNER JOIN (SELECT cliente_respuesta.id_cliente, MAX(cliente_respuesta.id_cliente_respuesta) AS id_ultima_rpta FROM cliente_respuesta INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente GROUP BY id_cliente) AS Ultima_rpta_x_usuario ON cliente_respuesta.id_cliente = Ultima_rpta_x_usuario.id_cliente WHERE (pregunta_cabecera.numero_pregunta = 4)) AS Datos";
            $strSQL_Preguntas = "SELECT numero_pregunta, SUM(NPS_7) AS NPS_7, SUM(NPS_5) AS NPS_5, SUM(NPS_4) AS NPS_4 FROM (SELECT pregunta_cabecera.numero_pregunta, CASE WHEN respuesta_detalle.valor1 >= 6 THEN 1 ELSE 0 end AS NPS_7, CASE WHEN respuesta_detalle.valor1 < 6 AND respuesta_detalle.valor1 > 4 THEN 1 ELSE 0 end AS NPS_5, CASE WHEN respuesta_detalle.valor1 <= 4 then 1 ELSE 0 end AS NPS_4 FROM respuesta INNER JOIN respuesta_detalle ON respuesta.id_respuesta = respuesta_detalle.id_respuesta INNER JOIN cliente_respuesta ON cliente_respuesta.id_respuesta = respuesta.id_respuesta INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente INNER JOIN pregunta_cabecera ON respuesta.id_pregunta_cabecera = pregunta_cabecera.id_pregunta_cabecera INNER JOIN (SELECT cliente_respuesta.id_cliente, MAX(cliente_respuesta.id_cliente_respuesta) AS id_ultima_rpta FROM cliente_respuesta INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente GROUP BY id_cliente " . ") AS Ultima_rpta_x_usuario ON cliente_respuesta.id_cliente = Ultima_rpta_x_usuario.id_cliente WHERE (pregunta_cabecera.numero_pregunta = 1 OR pregunta_cabecera.numero_pregunta = 2 OR pregunta_cabecera.numero_pregunta = 3) GROUP BY respuesta.id_respuesta " . ") AS Datos_Tmp GROUP BY numero_pregunta ORDER BY numero_pregunta";
        }

        $result             = DB::select($strSQL_NPS);
        $total              = 0;
        $promotor           = 0;
        $detractor          = 0;
        $html_preg_etiqueta = "";
        $html_preg          = "";

        foreach ($result as $key => $value) {
            if ($value->promedio >= 6.0) {
                $promotor++;
            } else if ($value->promedio <= 4.0) {
                $detractor++;
            } else {
                // neutro++;
            }
            $total++;
        }
        $nps_7 = (double)((float)($promotor * 100) / $total);
        $nps_4 = (double)((float)($detractor * 100) / $total);
        $nps_5 = (double)((float)($nps_7 - $nps_4));

        $porc_promotores  = round($nps_7, 1, PHP_ROUND_HALF_UP) . "%";
        $porc_nps         = round($nps_5, 1, PHP_ROUND_HALF_UP) . "%";
        $porc_detractores = round($nps_4, 1, PHP_ROUND_HALF_UP) . "%";

        $result = DB::select($strSQL_Lealtad);
        if (!is_null($result) || count($result)) {
            foreach ($result as $key => $value) {
                $cant_leal    = $value->Leal_SI;
                $cant_leal_no = $value->Leal_NO;
                $porc_lealtad = (($cant_leal / ($cant_leal . $cant_leal_no)) * 100) . "%";
            }
        }

        $result = DB::select($strSQL_Preguntas);
        if (!is_null($result) || count($result)) {
            foreach ($result as $key => $value) {
                $nps_7  = $value->NPS_7;
                $nps_5  = $value->NPS_5;
                $nps_4  = $value->NPS_4;
                $porc_7 = (($nps_7 / ($nps_7 . $nps_5 . $nps_4)) * 100);
                $porc_4 = (($nps_4 / ($nps_7 . $nps_5 . $nps_4)) * 100);

                if ($value->numero_pregunta == 1) {
                    $html_preg_etiqueta = "Efectivo";
                } else if ($value->numero_pregunta == 2) {
                    $html_preg_etiqueta = "F&aacute;cil";
                } else if ($value->numero_pregunta == 3) {
                    $html_preg_etiqueta = "Agradable";
                }


                $html_preg .= "<tr>";
                $html_preg .= "<td class='text-left'>" . $html_preg_etiqueta . "</td>";
                $html_preg .= "<td class='text-center'>" . round($porc_7, 1, PHP_ROUND_HALF_UP) . "%</td>";
                $html_preg .= "<td class='text-center'>" . round($porc_4, 1, PHP_ROUND_HALF_UP) . "%</td>";
                $html_preg .= "<td class='text-center'>" . round(($porc_7 - $porc_4), 1, PHP_ROUND_HALF_UP) . "%</td>";
                $html_preg .= "</tr>";
            }
        }

        return $html_preg . self::genNPS($strSQL_NPS);
    }

    /**
     * GET NPS (?) VALUE
     *
     * @param strSQL_NPS
     * @param mostrarComo
     * @param locale
     *
     * @return
     */
    public static function genNPS($strSQL_NPS)
    {
        $etiqueta_porc_7   = null;
        $etiqueta_porc_4   = null;
        $etiqueta_porc_nps = null;
        $porc_nps          = null;
        $porc_promotores   = null;
        $porc_detractores  = null;
        $out               = "";
        $ENCONTRO_ANTERIOR = false;

        try {
            $promotor  = 0;
            $neutro    = 0;
            $detractor = 0;
            $total     = 0;

            $promotor_2  = 0;
            $neutro_2    = 0;
            $detractor_2 = 0;
            $total_2     = 0;

            $result = DB::select($strSQL_NPS);

            foreach ($result as $key => $value) {
                if ($value->promedio >= 6.0) {
                    $promotor++;
                } else if ($value->promedio <= 4.0) {
                    $detractor++;
                } else {
                    $neutro++;
                }
                $total++;
            }

            $nps_7 = (double)((float)($promotor * 100) / $total);
            $nps_4 = (double)((float)($detractor * 100) / $total);
            $nps_5 = (double)((float)($nps_7 - $nps_4));

            if (($promotor + $detractor + $neutro) == 0.0) {
                $porc_7           = 0.0;
                $porc_4           = 0.0;
                $porc_nps         = "0 % ";
                $porc_promotores  = "0 % ";
                $porc_detractores = "0 % ";
            } else {
                $porc_7           = (double)((float)($promotor * 100) / $total);
                $porc_4           = (double)((float)($detractor * 100) / $total);
                $porc_promotores  = round($nps_7) . "%";
                $porc_nps         = round($nps_5) . "%";
                $porc_detractores = round($nps_4) . "%";
            }

            if ($ENCONTRO_ANTERIOR) {
                $nps_7_2 = (double)((float)($promotor_2 * 100) / $total_2);
                $nps_4_2 = (double)((float)($detractor_2 * 100) / $total_2);
                $nps_5_2 = (double)((float)($nps_7_2 - $nps_4_2));

                if (($nps_7_2 + $nps_5_2 + $nps_4_2) == 0.0) {
                    $porc_7_2 = 0.0;
                    $porc_4_2 = 0.0;
                } else {
                    $porc_7_2 = (($nps_7_2 / ($nps_7_2 + $nps_5_2 + $nps_4_2)) * 100);
                    $porc_4_2 = (($nps_4_2 / ($nps_7_2 + $nps_5_2 + $nps_4_2)) * 100);
                }

                if ($porc_7 > $porc_7_2) {
                    $etiqueta_porc_7 = " & nbsp;<i title = 'Mejor Porcentaje - Anterior " . round($porc_7_2) . "%' class=\"fa fa-long-arrow-up\"></i>";
                } else if ($porc_7 < $porc_7_2) {
                    $etiqueta_porc_7 = "&nbsp;<i title='Peor Porcentaje - Anterior " . round($porc_7_2) . "%' class=\"fa fa-long-arrow-down\"></i>";
                } else if ($porc_7 == $porc_7_2) {
                    $etiqueta_porc_7 = "&nbsp;<i title='Porcentaje Iguales' class=\"fa fa-exchange\"></i>";
                }

                if ($porc_4 > $porc_4_2) {
                    $etiqueta_porc_4 = "&nbsp;<i title='Mejor Porcentaje - Anterior " . round(porc_4_2) . "%' class=\"fa fa-long-arrow-up\"></i>";
                } else if ($porc_4 < $porc_4_2) {
                    $etiqueta_porc_4 = "&nbsp;<i title='Peor Porcentaje - Anterior " . round(porc_4_2) . "%' class=\"fa fa-long-arrow-down\"></i>";
                } else if ($porc_4 == $porc_4_2) {
                    $etiqueta_porc_4 = "&nbsp;<i title='Porcentaje Iguales' class=\"fa fa-exchange\"></i>";
                }

                if (($porc_7 - $porc_4) > ($porc_7_2 - $porc_4_2)) {
                    $etiqueta_porc_nps = "&nbsp;<i title='Mejor Porcentaje - Anterior " . round($porc_7_2 - $porc_4_2) . "%' class='icon icon-color icon-arrowthick-n'></span>";
                } else if (($porc_7 - $porc_4) < ($porc_7_2 - $porc_4_2)) {
                    $etiqueta_porc_nps = "&nbsp;<i title='Peor Porcentaje - Anterior " . round($porc_7_2 - $porc_4_2) . "%' class='icon icon-red icon-arrowthick-s'></i>";
                } else if (($porc_7 - $porc_4) == ($porc_7_2 - $porc_4_2)) {
                    $etiqueta_porc_nps = "&nbsp;<i title='Porcentaje Iguales' class=\"fa fa-exchange\"></i>";
                }
            }

            $out .= "<tr>";
            $out .= "<td class='text-left'><b><span title='NPS: &Iacute;ndice de Promotores Netos&#13;Obtenido por la diferencia entre el % de promotores menos el % de detractores'>NPS</span></b></td>";
            $out .= "<td class='text-center'><b>" . $porc_promotores . $etiqueta_porc_7 . "</b></td>";
            $out .= "<td class='text-center'><b>" . $porc_detractores . $etiqueta_porc_4 . "</b></td>";
            $out .= "<td class='text-center'><b>" . $porc_nps . $etiqueta_porc_nps . "</b></td>";
            $out .= "</tr>";
        } catch (\Exception $e) {
            throw $e;
        }

        return $out;
    }

    /**
     * Display a listing of the resource.
     * GET /admin
     *
     * @return Response
     */
    public function index($idcliente = null)
    {
        if (!\Auth::guest()) {
            return \Redirect::to('admin/cpanel');
        }

        $theme = \Apariencia::find(\Config::get('default.idapariencia'));

        return \View::make('admin.index')->withTheme($theme);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse|string
     */
    public function login()
    {
        try {
            if (!\Auth::guest()) {
                return Redirect::to('admin/cpanel');
            }

            $credentials = [
                'username' => e(\Input::get('username')),
                'password' => e(\Input::get('password')),
            ];
            $rules       = [
                'username' => 'required',
                'password' => 'required',
            ];

            $validator = \Validator::make($credentials, $rules);


            if ($validator->fails()) {
                if (\Request::ajax()) {
                    return json_encode('ERROR');
                }

                return \Redirect::back()->withErrors($validator->messages())->withInput(\Input::except('_token'));
            }

            if (Auth::attempt($credentials, Input::get('remember', false))) {
                return \Redirect::to('admin/cpanel');
            }

            $error = new Illuminate\Support\MessageBag();
            $error->add('username', 'Error al ingresar al panel de control.');

            return \Redirect::back()->withErrors($error)->withInput();
        } catch (\Exception $e) {
            App::abort('Error al iniciar sesión.');
            //            dd($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();

        if (Request::ajax()) {
            return $msg = 'OK';
        }

        return Redirect::to('admin/login');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function cpanel()
    {
        return View::make('admin.cpanel');
    }

    /**
     * @return mixed
     */
    public function loadSurvey()
    {
        $client = \Auth::user()->cliente;
        $plan   = $client->plan;

        if (!is_null($plan)) {
            $survey = $client->encuesta;

            if (is_null($survey)) {
                throw new \Exception('Cliente no tiene encuesta');
            }

            return \View::make('admin.survey.loadSurvey')->withSurvey($survey)->with('isMy', true);
        }

        throw new \Exception('Cliente no tiene plan');
    }

    /**
     * @return $this
     */
    public function createClient()
    {
        // Validate input values
        $validator = \Validator::make(\Input::all(), \Cliente::$rules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Input::except('_token'));
        }

        // Create survey
        $survey = \Encuesta::create(['id_estado' => 1]);

        // Generate default questions
        \PreguntaCabecera::generateDefaultQuestions($survey);

        // Create client
        $client = \Cliente::firstOrCreate([
            'rut_cliente'       => \Input::get('rut_cliente'),
            'nombre_cliente'    => \Input::get('nombre_cliente'),
            'fono_cliente'      => \Input::get('fono_cliente'),
            'correo_cliente'    => \Input::get('correo_cliente'),
            'direccion_cliente' => \Input::get('direccion_cliente'),
            'id_sector'         => \Input::get('sector'), // ????
            'id_ciudad'         => \Input::get('ciudad'),
            'id_tipo_cliente'   => \Input::get(''), // 1
            'id_plan'           => \Input::get('plan'),
        ]);

        // Assciate survey to client
        $client->encuesta()->associate($survey);
        $client->save();
    }

}