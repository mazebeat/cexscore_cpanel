<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class EncuestasClienteController extends \ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('csrf');
    }

    /**
     * @param \Encuesta $survey
     */
    public static function generateDefaultSurvey(Encuesta $survey)
    {
        $question1 = new PreguntaCabecera(['descripcion_1' => 'Pregunta de Efectividad', 'numero_pregunta' => 1, 'id_tipo_respuesta' => 1, 'id_estado' => 1, 'id_momento' => 1]);
        $question1 = $survey->preguntas()->save($question1);

        $subquestion1 = new PreguntaCabecera([
            'descripcion_1'     => '¿Por qué califica con esa nota? (opcional)',
            'id_pregunta_padre' => $question1->id_pregunta_cabecera,
            'id_tipo_respuesta' => 5,
            'id_estado'         => 1,
            'id_momento'        => 1,
        ]);
        $survey->preguntas()->save($subquestion1);

        $question2 = new PreguntaCabecera(['descripcion_1' => 'Pregunta de Facilidad', 'numero_pregunta' => 2, 'id_tipo_respuesta' => 1, 'id_estado' => 1, 'id_momento' => 2]);
        $question2 = $survey->preguntas()->save($question2);

        $subquestion2 = new PreguntaCabecera([
            'descripcion_1'     => '¿Por qué califica con esa nota? (opcional)',
            'id_pregunta_padre' => $question2->id_pregunta_cabecera,
            'id_tipo_respuesta' => 5,
            'id_estado'         => 1,
            'id_momento'        => 2,
        ]);
        $survey->preguntas()->save($subquestion2);

        $question3 = new PreguntaCabecera(['descripcion_1' => ' Pregunta de lo Grato de la interacci�n', 'numero_pregunta' => 3, 'id_tipo_respuesta' => 1, 'id_momento' => 3]);
        $question3 = $survey->preguntas()->save($question3);

        $subquestion3 = new PreguntaCabecera([
            'descripcion_1'     => '¿Por qué califica con esa nota? (opcional)',
            'id_pregunta_padre' => $question3->id_pregunta_cabecera,
            'id_tipo_respuesta' => 5,
            'id_estado'         => 1,
            'id_momento'        => 3,
        ]);
        $survey->preguntas()->save($subquestion3);

        $question4 = new PreguntaCabecera([
            'descripcion_1'     => '¿Recomendaría nuestra empresa a sus amigos/conocidos?',
            'numero_pregunta'   => 4,
            'id_tipo_respuesta' => 6,
            'id_estado'         => 1,
            'id_momento'        => 4,
        ]);
        $survey->preguntas()->save($question4);
    }

    /**
     * @param null $idcliente
     * @param null $canal
     * @param null $moment
     *
     * @return mixed
     */
    public function index($idcliente = null, $canal = null, $moment = null)
    {
        if (isset($idcliente) && isset($canal) && isset($moment)) {

            try {
                if (Session::has('survey.canal')) {
                    Session::forget('survey.canal');
                }

                // Canal
                if (Crypt::decrypt($canal) == null) {
                    $error          = new stdClass();
                    $error->code    = 500;
                    $error->message = 'Canal no encontrado.';

                    return Redirect::to('survey/error')->with('error', $error);
                }

                $idCanal = Canal::whereCodigoCanal(Crypt::decrypt($canal))->first(['id_canal'])->id_canal;
                Session::put('survey.canal', Crypt::encrypt($idCanal));

                // Moment
                if (Crypt::decrypt($moment) == null) {
                    $error          = new stdClass();
                    $error->code    = 500;
                    $error->message = 'Momento no identificado.';

                    return Redirect::to('survey/error')->with('error', $error);
                }

                // Client
                if (Crypt::decrypt($idcliente) == null) {
                    $error          = new stdClass();
                    $error->code    = 500;
                    $error->message = 'ID Cliente no encontrado.';

                    return Redirect::to('survey/error')->with('error', $error);
                }

                $client = Cliente::find(Crypt::decrypt($idcliente));

                Visita::create([
                    'id_cliente' => Crypt::decrypt($idcliente),
                    'id_momento' => Crypt::decrypt($moment),
                    'id_canal'   => $idCanal,
                ]);

                if (!is_null($client) && $client->first()->exists) {

                    if (!is_null($client->plan)) {
                        $survey = $client->encuesta;
                        $theme  = $client->theme();

                        if (!Session::has('survey.theme')) {
                            Session::put('survey.theme', $theme);
                        }

                        if (!Session::has('survey.survey')) {
                            Session::put('survey.survey', $survey);
                        }

                        if (!Session::has('survey.client')) {
                            Session::put('survey.client', $client);
                        }

                        if (!Session::has('survey.moment')) {
                            Session::put('survey.moment', $moment);
                        }
                    }

                    return View::make('survey.encuesta')->withMoment($moment)->withTheme($theme)->withSurvey($survey)->withClient($client);
                }

            } catch (Exception $e) {
                self::throwError($e);
            }
        }

        return Redirect::to('survey/error');
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        try {
            // Session values
            $inputs = Input::except(['_token']);
            $client = Session::get('survey.client', null);
            $canal  = Session::get('survey.canal', null);
            $moment = Session::get('survey.moment', null);
            $survey = Session::get('survey.survey', null);

            if (is_null($client) || is_null($canal) || is_null($moment) || is_null($survey)) {
                $errors = 'Error al guardar sus respuestas, por favor refresque su p�gina.';

                return Redirect::back()->withErrors($errors)->withInput($inputs);
            }

            if (!self::validateAnswers($inputs)) {
                $errors = 'Debe contestar todas las preguntas.';

                return Redirect::back()->withErrors($errors)->withInput($inputs);
            }

            $data = self::processAnswers($inputs);

            if (is_null($data) && !self::objectHasProperty($data['answers'])) {
                $errors = 'Error en la consulta.';

                return Redirect::back()->withErrors($errors)->withInput($inputs);
            }

            $idsurvey = $survey->id_encuesta;
            $moment   = Crypt::decrypt($moment);
            $canal    = Crypt::decrypt($canal);

            if (count($data['user']) && self::objectHasProperty($data['user'])) {
                $value = $data['user'];

                $born = Carbon::parse($value->age);
                $age  = $born->age;

                $user                   = new Usuario();
                $user->nombre_usuario   = $value->name;
                $user->edad_usuario     = $age;
                $user->fecha_nacimiento = $born;
                $user->genero_usuario   = $value->gender;
                $user->correo_usuario   = $value->email;
                $user->rut_usuario      = $value->rut;
                $user->id_tipo_usuario  = 3;
                $user->id_cliente       = $client->id_cliente;

                if (isset($value->wish_email) && (int)$value->wish_email == 1) {
                    $user->desea_correo_usuario = 'NO';
                }

                $user->save();
            }

            if (isset($user) && !is_null($user)) {
                $iduser = $user->id_usuario;
            } else {
                $iduser = null;
            }

            $acumulador = 0;
            foreach ($data['answers'] as $key => $value) {
                // Inserta cabecera de la respuesta
                $respuesta                       = new Respuesta();
                $respuesta->id_estado            = 1;
                $respuesta->id_canal             = $canal;
                $respuesta->id_encuesta          = $idsurvey;
                $respuesta->id_cliente           = $client->id_cliente;
                $respuesta->id_pregunta_cabecera = $value->id_pregunta_cabecera;
                $respuesta->id_momento           = $moment;
                $respuesta->id_usuario           = $iduser;

                $respuesta = $client->respuestas()->save($respuesta, ['ultima_respuesta' => Carbon::now(), 'id_estado' => 1]);

                $respuestaDetalle = new RespuestaDetalle();
                if (isset($value->value)) {
                    $acumulador               = (int)$acumulador + (int)$value->value;
                    $respuestaDetalle->valor1 = $value->value;
                } else {
                    $respuestaDetalle->valor1 = null;
                }
                if (isset($value->text)) {
                    $respuestaDetalle->valor2 = $value->text;
                } else {
                    $respuestaDetalle->valor2 = null;
                }
                $respuestaDetalle->id_respuesta = $respuesta->id_respuesta;
                $respuestaDetalle->save();
            }

            // Calcula promedio
            $promedio = self::calculateProm($acumulador);

            // Clasificacion
            $clasificacion = self::promClassification($promedio);

            // Guarda NPS
            $nps                = new Nps();
            $nps->id_cliente    = $client->id_cliente;
            $nps->id_usuario    = $iduser;
            $nps->id_encuesta   = $idsurvey;
            $nps->id_momento    = $moment;
            $nps->id_canal      = $canal;
            $nps->fecha         = Carbon::now();
            $nps->promedio      = $promedio;
            $nps->clasificacion = $clasificacion;
            $nps->save();

        } catch (Exception $e) {
            self::throwError($e);
        }

        return \Redirect::to('survey/success');
    }

    /**
     * @param array $inputs
     *
     * @return bool
     */
    public static function validateAnswers(array $inputs)
    {
        try {
            if (!is_array($inputs)) {
                return false;
            }

            $count = 0;

            foreach ($inputs as $key => $value) {
                if (\Str::startsWith($key, 'question')) {
                    $count++;
                }
            }

            if ($count === 4) {
                return true;
            }
        } catch (\Exception $e) {
            self::throwError($e);
        }

        return false;
    }

    /**
     * @param array $inputs
     *
     * @return null|\stdClass
     */
    public static function processAnswers(array $inputs)
    {
        try {
            if (!is_array($inputs)) {
                return null;
            }

            return self::processKeyAnswer($inputs);
        } catch (\Exception $e) {
            static::throwError($e);
        }

        return null;
    }

    /**
     * @param array $inputs
     *
     * @return array
     */
    public static function processKeyAnswer(array $inputs)
    {
        $answers = new stdClass();
        $user    = new stdClass();

        try {
            foreach ($inputs as $key => $value) {

                if (\Str::startsWith($key, 'question')) {
                    $split = explode('_', $key);
                    $name  = $split[0] . $split[1];

                    $tmp = array('id_pregunta_cabecera' => (int)$split[2]);

                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if ($k == 'value' && !is_null($v)) {
                                $tmp[$k] = (int)e($v);
                            } else {
                                if (is_null($v) || empty($value)) {
                                    $tmp[$k] = null;
                                } else {
                                    $tmp[$k] = e($v);
                                }
                            }
                        }
                    }

                    $answers->$name = (object)$tmp;
                } else {
                    if ($value == null || empty($value)) {
                        $value = null;
                    }
                    $user->$key = $value;
                }
            }
        } catch (Exception $e) {
            self::throwError($e);
        }

        return ['answers' => $answers, 'user' => $user];
    }

    /**
     * @param $acumulador
     *
     * @return float
     */
    public static function calculateProm($acumulador)
    {
        $promedio = $acumulador / 3;
        $promedio = round($promedio, 1);

        return $promedio;
    }

    /**
     * @param $promedio
     *
     * @return string
     */
    public static function promClassification($promedio)
    {
        $clasificacion = "";
        if ($promedio >= 6.0) {
            $clasificacion = "Promotor";

            return $clasificacion;
        } else if ($promedio <= 4.0) {
            $clasificacion = "Detractor";

            return $clasificacion;
        } else {
            $clasificacion = "Neutro";

            return $clasificacion;
        }
    }
}