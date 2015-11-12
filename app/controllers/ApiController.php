<?php

use Illuminate\Support\Facades\Session;

class ApiController extends \BaseController
{
    protected $view_params = array();
    private   $errors      = array();

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        if (Session::has('err')) {
            $this->errors             = Session::get('err');
            $this->view_params['err'] = $this->errors;
        }
    }

    /**
     * @param $input
     *
     * @return bool
     */
    public static function objectHasProperty($input)
    {
        return (is_object($input) && array_filter(get_object_vars($input), function ($val) {
                return (is_string($val) && strlen($val)) || ($val !== null);
            })) ? true : false;
    }

    /**
     * @param $data
     * @param $survey
     *
     * @return null|static
     * @throws Exception
     */
    public static function saveClient($data, $survey)
    {
        $client = null;

        try {
            if (!is_null($data) || count($data)) {
                array_forget($data, 'pais');
                array_forget($data, 'region');
                if (!array_key_exists('id_ciudad', $data)) {
                    $data = array_add($data, 'id_ciudad', 1);
                } else {
                    if (array_get($data, 'id_ciudad') == '' || array_get($data, 'id_ciudad') == null || !count(array_get($data, 'id_ciudad'))) {
                        array_set($data, 'id_ciudad', 1);
                    }
                }
                $data = array_add($data, 'id_estado', 1);

                $client = \Cliente::firstOrCreate($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $client;
    }

    /**
     * @param      $admin
     * @param null $client
     * @param null $survey
     */
    public static function saveAdministrator($data, $client = null, $survey = null)
    {
        $admin = null;
        try {
            if (!is_null($data) && !is_null($client)) {
                $username = self::randomCsUsername($data);
                $data     = array_add($data, 'nombre', $data['nombre_usuario'] . ' ' . $data['apellido_usuario']);
                $data     = array_add($data, 'usuario', $username);
                $data     = array_add($data, 'responsable', 1);
                $data     = array_add($data, 'pwdusuario', 'e10adc3949ba59abbe56e057f20f883e');
                array_set($data, 'id_cliente', $client->id_cliente);
                array_set($data, 'id_perfil', 4);

                array_forget($data, ['nombre_usuario', 'apellido_usuario']);

                $admin = \CsUsuario::firstOrCreate($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $admin;
    }

    /**
     * @param     $user
     * @param int $add
     *
     * @return null|string
     * @throws Exception
     */
    public static function randomUsername($user, $add = 0)
    {
        $username = null;

        try {
            if (!is_null($user)) {
                $fname    = array_get($user, 'nombre_usuario');
                $lname    = array_get($user, 'apellido_usuario');
                $username = Str::lower(Str::camel(Str::ascii(mb_substr($fname, 0, 1) . $lname)));

                if ($add != 0) {
                    $username .= $add;
                }

                $exist = Usuario::where('username', $username)->first();

                if (!is_null($exist)) {
                    $add++;
                    $username = self::randomUsername($user, $add);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $username;
    }

    /**
     * @param     $user
     * @param int $add
     *
     * @return null|string
     * @throws Exception
     */
    public static function randomCsUsername($user, $add = 0)
    {
        $username = null;

        try {
            if (!is_null($user)) {
                $fname    = array_get($user, 'nombre_usuario');
                $lname    = array_get($user, 'apellido_usuario');
                $username = Str::lower(Str::camel(Str::ascii(mb_substr($fname, 0, 1) . $lname)));

                if ($add != 0) {
                    $username .= $add;
                }

                $exist = CsUsuario::where('usuario', $username)->first();

                if (!is_null($exist)) {
                    $add++;
                    $username = self::randomCsUsername($user, $add);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $username;
    }

    /**
     * @param      $admin
     * @param null $client
     * @param null $survey
     */
    public static function saveCurrentUser($data, $client = null, $survey = null)
    {
        $user = null;

        try {
            if (!is_null($data) || count($data)) {

                $username = self::randomCsUsername($data);
                $data     = array_add($data, 'usuario', $username);
                $data     = array_add($data, 'responsable', 0);
                $data     = array_add($data, 'pwdusuario', 'e10adc3949ba59abbe56e057f20f883e');
                $data     = array_add($data, 'id_perfil', 3);
                $user     = \CsUsuario::firstOrCreate($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $user;
    }

    /**
     * @param $data
     */
    public static function saveMoments($data, $cliente = null, $save = false)
    {
        $moments = array();
        if (!is_null($data) && !is_null($cliente)) {
            if (!$save) {
                foreach ($data['momentos'] as $key => $value) {
                    $moment                             = $cliente->encuesta->momentos->find($value['id_momento']);
                    $moment->pivot->descripcion_momento = $value['descripcion_momento'];
                    $moment->pivot->save();

                    array_push($moments, $moment);
                }
            } else {
                foreach ($data as $key => $value) {
                    $n      = ($key + 1);
                    $moment = Momento::firstOrCreate(['id_momento' => $n, 'descripcion_momento' => 'Momento ' . $n]);
                    $moment = $moment->encuestas->first();

                    if (!is_null($moment)) {
                        $da     = [
                            'id_momento_encuesta' => 0,
                            'id_momento'          => $n,
                            'descripcion_momento' => $value['descripcion_momento'],
                            'id_cliente'          => $cliente->id_cliente,
                            'id_encuesta'         => $cliente->encuesta->id_encuesta,
                        ];
                        $moment = MomentoEncuesta::firstOrCreate($da);

                        if (!is_null($moment)) {
                            $canal         = Canal::find($value['canal']);
                            $url           = '/survey' . '/' . Crypt::encrypt($cliente->id_cliente) . '/' . Crypt::encrypt($canal->codigo_canal) . '/' . Crypt::encrypt($n);
                            $u             = new Url;
                            $u->url        = $url;
                            $u->given      = Url::getShortenedUrl();
                            $u->id_cliente = $cliente->id_cliente;
                            $u->id_canal   = $canal->id_canal;
                            $u->id_momento = $n;

                            if ($u->save()) {
                                array_push($moments, $moment);
                            }
                        }
                    }
                }
            }

            return $moments;
        }
    }

    /**
     * @param $name
     * @param $data
     * @param $inputs
     *
     * @return null|static
     */
    public static function saveTheme($name, $data, $inputs)
    {
        $theme = null;

        try {
            if (!is_null($data) || count($data)) {
                $folder = public_path('image' . DIRECTORY_SEPARATOR . $name);
                if (!\File::exists($folder)) {
                    \File::makeDirectory($folder);
                }

                foreach ($inputs as $key => $value) {
                    $filename = $key . '.' . $value->guessClientExtension();
                    $path     = '/image' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $filename;

                    $files = File::allFiles($folder);
                    foreach ($files as $file) {
                        if (File::exists((string)$file) && Str::contains((string)$file, $key)) {
                            File::delete((string)$file);
                        }
                    }

                    $value->move($folder, $filename);
                    $data = array_add($data, $key, $path);
                }

                $theme = \Apariencia::firstOrCreate($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $theme;
    }

    /**
     * @param $name
     * @param $data
     * @param $inputs
     *
     * @return null|static
     */
    public static function updateTheme($cliente, $data, $inputs)
    {
        $theme = null;

        try {
            if (!is_null($data) || count($data)) {
                $folder = public_path('image' . DIRECTORY_SEPARATOR . $name);
                if (!\File::exists($folder)) {
                    \File::makeDirectory($folder);
                }

                foreach ($inputs as $key => $value) {
                    $filename = $key . '.' . $value->guessClientExtension();
                    $path     = '/image' . DIRECTORY_SEPARATOR . Str::camel($cliente->nombre_cliente) . DIRECTORY_SEPARATOR . $filename;

                    $files = File::allFiles($folder);
                    foreach ($files as $file) {
                        if (File::exists((string)$file) && Str::contains((string)$file, $key)) {
                            File::delete((string)$file);
                        }
                    }

                    $value->move($folder, $filename);
                    $data = array_add($data, $key, $path);
                }

                $theme = $cliente->theme->update($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $theme;
    }

    /**
     * @param array $data
     *
     * @return null
     * @throws Exception
     */
    public static function saveQuestions($data = array())
    {
        $id = null;

        try {
            if (!is_null($data) || count($data)) {
                $id = \PreguntaCabecera::insertGetId($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $id;
    }

    /**
     * @param array $data
     *
     * @return null|static
     */
    public static function saveSurvey($data = array())
    {
        $survey = null;

        try {
            if (!is_null($data) || count($data)) {
                $data = array_add($data, 'id_estado', 1);
                array_forget($data, 'title');

                $validation = \Validator::make($data, \Encuesta::$rules);

                if ($validation->passes()) {
                    $survey = \Encuesta::firstOrCreate($data);

                }
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $survey;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateMessage()
    {
        $theme  = null;
        $survey = null;
        if (!Session::has('message') || !is_object(Session::get('message'))) {
            $message           = new stdClass();
            $message->title    = Str::hes('&iexcl;Agradecemos sus Respuestas&#33;');
            $message->subtitle = '';
        } else {
            $message = Session::get('message');
        }

        //$script = "setTimeout('window.location.href=\"" . URL::to('/') . "/\";', 5000); if (typeof window.event == 'undefined'){ document.onkeypress = function(e){ var test_var=e.target.nodeName.toUpperCase(); if (e.target.type) var test_type=e.target.type.toUpperCase(); if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA'){ return e.keyCode; }else if (e.keyCode == 8 || e.keyCode == 116 || e.keyCode == 122){ e.preventDefault(); } } }else{ document.onkeydown = function(){ var test_var=event.srcElement.tagName.toUpperCase(); if (event.srcElement.type) var test_type=event.srcElement.type.toUpperCase(); if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA'){ return event.keyCode; } else if (event.keyCode == 8 || e.keyCode == 116 || e.keyCode == 122){ event.returnValue=false; } } } ";
        $script = '';

        if (Session::has('survey-theme')) {
            $theme = Session::get('survey-theme');
        } else if (Session::has('theme')) {
            $theme = Session::get('theme');
        }

        return View::make('survey.messages')->withMessage($message)->withScript($script)->withTheme($theme)->withSurvey($survey);
    }

    /**
     * @return mixed
     */
    public function generateError()
    {
        try {
            if (!Session::has('error') || !is_object(Session::get('error'))) {
                $error          = new stdClass();
                $error->code    = 401;
                $error->message = 'Error Inesperado.';
            } else {
                $error = Session::get('error');
            }
            $survey = null;
            $theme  = null;

            if (Session::has('survey-theme')) {
                $theme = Session::get('survey-theme');
            } else if (Session::has('theme')) {
                $theme = Session::get('theme');
            }

            return View::make('survey.errors')->withError($error)->withTheme($theme)->withSurvey($survey);
        } catch (Exception $e) {
            static::throwError($e);
        }
    }

    /**
     * @param Exception $e
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function throwError(\Exception $e)
    {
        if (!Config::get('app.debug')) {
            $error          = new stdClass();
            $error->code    = $e->getCode();
            $error->message = $e->getMessage();

            return Redirect::to('survey/error')->with('error', $error);
        }

        throw $e;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modifySurvey()
    {
        try {
            $inputs    = \Input::except(['_token', 'survey', 'plan']);
            $valid     = self::createBasicRules($inputs);
            $validator = \Validator::make(\Input::all(), $valid['rules'], $valid['messages']);

            if ($validator->fails()) {
                return \Redirect::back()->withErrors($validator)->withInput(\Input::except('_token'));
            }

            $questions  = \Auth::user()->cliente->encuesta->preguntas;
            $idencuesta = null;
            $idplan     = null;
            $x          = 0;

            if ($idplan == 1) {
                $errors = new MessageBag();
                $errors->add('inesperado', 'No mantiene los privilegios para modificar.');

                return \Redirect::back()->withErrors($errors)->withInput(\Input::except('_token'));
            }

            if (count($inputs) <= 0) {
                $errors = new MessageBag();
                $errors->add('inesperado', 'Cantidad de textos incorrecta.');

                return \Redirect::back()->withErrors($errors)->withInput(\Input::except('_token'));
            }

            $ids = self::FilterQuestions($inputs);

            foreach ($questions as $question) {
                if ($question->id_encuesta == $idencuesta && array_key_exists($question->id_pregunta_cabecera, $ids) && is_null($question->id_pregunta_padre)) {
                    $question->descripcion_1 = $ids[$question->id_pregunta_cabecera];

                    if ($question->save()) {
                        $x++;
                    }
                }
            }

            return Redirect::to('admin/survey/load');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param null $inputs
     *
     * @return array
     */
    public static function createBasicRules($inputs = null)
    {
        try {
            $rules    = [];
            $messages = [];
            $count    = 1;

            if (!is_null($inputs)) {
                foreach ($inputs as $key => $value) {
                    $rules[$key]                  = 'required';
                    $messages[$key . '.required'] = 'El texto en la pregunta ' . $count++ . ' es obligatorio.';
                }
            }

            return array('rules' => $rules, 'messages' => $messages);

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $inputs
     * @param $ids
     *
     * @return mixed
     */
    public static function FilterQuestions($inputs)
    {
        try {
            foreach ($inputs as $key => $value) {
                if (\Str::startsWith($key, 'question')) {
                    $id       = (int)str_replace('question', '', $key);
                    $ids[$id] = $value;
                }
            }
        } catch (\Exception $ex) {
            throw $ex;
        }

        return $ids;
    }

    /**
     * @param $data
     *
     * @return string
     * @throws \Exception
     */
    public function modifySurvey2($data, $survey)
    {
        try {
            $valid     = self::createBasicRules($data);
            $validator = \Validator::make($data, $valid['rules'], $valid['messages']);

            if ($validator->fails()) {
                return \Redirect::back()->withErrors($validator)->withInput();
            }

            $questions = $survey->preguntas;
            $x         = 0;

            if (count($data) <= 0) {
                $errors = new \MessageBag();
                $errors->add('inesperado', 'Cantidad de textos incorrecta.');

                return \Redirect::back()->withErrors($errors)->withInput(\Input::except('_token'));
            }

            $ids = self::FilterQuestions($data);

            foreach ($questions as $question) {
                if ($question->id_encuesta == $survey->id_encuesta && array_key_exists($question->id_pregunta_cabecera, $ids) && is_null($question->id_pregunta_padre)) {
                    $question->descripcion_1 = $ids[$question->id_pregunta_cabecera];

                    if ($question->save()) {
                        $x++;
                    }
                }
            }

            if ($x != 4) {
                $errors = new MessageBag();
                $errors->add('inesperado', 'Error al procesar solicitud.');

                return Redirect::back()->withErrors($errors)->withInput(Input::except('_token'));
            }

            return Redirect::to('admin/survey/load');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function setError($str)
    {
        if (!isset($this->view_params['err']) || $this->view_params['err'] == null) {
            $this->view_params['err'] = array();
        }
        if (!isset($this->errors) || $this->errors == null) {
            $this->errors = array();
        }
        array_push($this->view_params['err'], $str);
        array_push($this->errors, $str);
        Session::put('err', $this->errors);
    }

    protected function getErrors()
    {
        return $this->errors;
    }

}
