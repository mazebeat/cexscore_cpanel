<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ApiController extends \BaseController
{
    protected $view_params = array();
    private   $errors      = array();

    public function __construct()
    {
        if (Session::has('err')) {
            $this->errors             = Session::get('err');
            $this->view_params['err'] = $this->errors;
        }
    }

    public static function objectHasProperty($input)
    {
        return (is_object($input) && array_filter(get_object_vars($input), function ($val) {
                return (is_string($val) && strlen($val)) || ($val !== null);
            })) ? true : false;
    }

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

                if (array_get($data, 'fecha_nacimiento') != '' || array_get($data, 'fecha_nacimiento') != null) {
                    $born = Carbon::parse(array_get($data, 'fecha_nacimiento'));
                    array_set($data, 'edad', $born->age);
                } else {
                    array_set($data, 'fecha_nacimiento', null);
                }

                $admin = \CsUsuario::firstOrCreate($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $admin;
    }

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

    public static function saveCurrentUser($data, $client = null, $survey = null)
    {
        $user = null;

        try {
            if (!is_null($data) || count($data)) {

                $username = self::randomCsUsername($data);
                $data     = array_add($data, 'usuario', $username);
                $data     = array_add($data, 'responsable', 0);
                $data     = array_add($data, 'pwdusuario', md5('123456')); // 'e10adc3949ba59abbe56e057f20f883e'
                $data     = array_add($data, 'id_perfil', 3);
                $born     = Carbon::parse(array_get($data, 'fecha_nacimiento'));
                array_set($data, 'edad', $born->age);

                $user = \CsUsuario::firstOrCreate($data);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $user;
    }

    public static function saveMoments($data, $cliente = null, $save = false)
    {
        try {
            $moments = array();
            if (!is_null($data) && !is_null($cliente)) {
                if (!$save) {
                    if (count($data['momentos']) > 0) {
                        foreach ($data['momentos'] as $key => $value) {
//                            $moment = $cliente->encuesta->momentos->find($value['id_momento']);
                            $moment = MomentoEncuesta::where('id_cliente', $cliente->id_cliente)->where('id_momento', $value['id_momento'])->first();
                            if (!is_null($moment) && $moment->descripcion_momento != $value['descripcion_momento']) {
                                $moment->descripcion_momento = $value['descripcion_momento'];
                                $moment->updated_at          = Carbon::now();
                                $moment->save();
                            }
                            if (is_null($moment)) {
                                $max = $cliente->plan->cantidad_momentos_plan;
                                $now = MomentoEncuesta::where('id_cliente', $cliente->id_cliente)->where('id_encuesta', $cliente->encuesta->id_encuesta)->count();

                                if ($max <= $now) {
                                    return Redirect::back()->withErrors(['message' => 'Cantidad máxima de momentos alcanzada.']);
                                }

                                $next = (int)$key + 1;
                                Momento::firstOrCreate(['id_momento' => $next, 'descripcion_momento' => 'Momento ' . $next, 'id_estado' => 1]);

                                $momentoencuesta = MomentoEncuesta::firstOrCreate([
                                    'id_momento'          => $next,
                                    'descripcion_momento' => $value['descripcion_momento'],
                                    'id_cliente'          => $cliente->id_cliente,
                                    'id_encuesta'         => $value['id_encuesta'],
                                ]);

                                if (!is_null($momentoencuesta)) {
                                    $canal = Canal::find(1);
                                    $uri   = '/survey' . '/' . Crypt::encrypt($cliente->id_cliente) . '/' . Crypt::encrypt('fb') . '/' . Crypt::encrypt($next);

                                    $url = Url::firstOrCreate([
                                        'url'        => $uri,
                                        'given'      => Url::getShortenedUrl(),
                                        'id_cliente' => $cliente->id_cliente,
                                        'id_canal'   => 1,
                                        'id_momento' => $next,
                                    ]);

                                    if (!is_null($url)) {
                                        if (!File::exists(public_path('temp/' . $cliente->id_cliente))) {
                                            File::makeDirectory(public_path('temp/' . $cliente->id_cliente), (int)$mode = 777, (bool)$recursive = true, (bool)$force = true);
                                        } else {
                                            if (!is_writable(public_path('temp/' . $cliente->id_cliente))) {
                                                if (!chmod(public_path('temp/' . $cliente->id_cliente))) {
                                                    Log::error("Cannot change the mode of file " . public_path('temp/' . $cliente->id_cliente) . ")");
                                                    exit;
                                                };
                                            }
                                        }
                                        $file = public_path('temp/' . $cliente->id_cliente . '/' . $next . '.png');
                                        self::createQrCode($file, url($url->given));

                                        if (File::exists($file)) {
                                            array_push($moments, $momentoencuesta);
                                        }
                                    }
                                }
                            }

                            array_push($moments, $moment);
                        }
                    }
                } else {
                    for ($i = 1; $i <= count($data); $i++) {
                        $moment = Momento::firstOrCreate(['id_momento' => $i, 'descripcion_momento' => 'Momento ' . $i, 'id_estado' => 1]);
                    }

                    if (!is_null($moment)) {
                        $count = 1;
                        foreach ($data as $key => $value) {
                            $momentoencuesta = MomentoEncuesta::firstOrCreate([
                                'id_momento'          => $count,
                                'descripcion_momento' => $value['descripcion_momento'],
                                'id_cliente'          => $cliente->id_cliente,
                                'id_encuesta'         => $cliente->encuesta->id_encuesta,
                            ]);

                            if (!is_null($momentoencuesta)) {
                                $canal = Canal::find($value['canal']);
                                $uri   = '/survey' . '/' . Crypt::encrypt($cliente->id_cliente) . '/' . Crypt::encrypt($canal->codigo_canal) . '/' . Crypt::encrypt($count);

                                $url = Url::firstOrCreate([
                                    'url'        => $uri,
                                    'given'      => Url::getShortenedUrl(),
                                    'id_cliente' => $cliente->id_cliente,
                                    'id_canal'   => 1,
                                    'id_momento' => $count,
                                ]);

                                if (!is_null($url)) {
                                    if (!File::exists(public_path('temp/' . $cliente->id_cliente))) {
                                        File::makeDirectory(public_path('temp/' . $cliente->id_cliente), (int)$mode = 777, (bool)$recursive = true, (bool)$force = true);
                                    } else {
                                        if (!is_writable(public_path('temp/' . $cliente->id_cliente))) {
                                            if (!chmod(public_path('temp/' . $cliente->id_cliente))) {
                                                Log::error("Cannot change the mode of file " . public_path('temp/' . $cliente->id_cliente) . ")");
                                                exit;
                                            };
                                        }
                                    }

                                    $file = public_path('temp/' . $cliente->id_cliente . '/' . $count . '.png');
                                    self::createQrCode($file, url($url->given));

                                    if (File::exists($file)) {
                                        array_push($moments, $momentoencuesta);
                                    }
                                }
                            } else {
                                throw new \Exception('Error al crear momento/encuesta', 500);
                            }
                            $count++;
                        }
                    } else {
                        throw new \Exception('Error al crear momentos', 500);
                    }
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $moments;
    }

    public static function saveTheme($name, $data, $inputs)
    {
        $theme = null;

        try {
            if (!is_null($data) || count($data)) {
                $folder = public_path('image' . DIRECTORY_SEPARATOR . $name);
                if (!\File::exists($folder)) {
                    \File::makeDirectory($folder, (int)$mode = 777, (bool)$recursive = true, (bool)$force = true);
                } else {
                    if (!is_writable($folder)) {
                        if (!chmod($folder)) {
                            Log::error("Cannot change the mode of file " . $folder . ")");
                            exit;
                        };
                    }
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

    public static function updateTheme($cliente, $data, $inputs)
    {
        $theme = null;

        try {
            if (count($inputs)) {
                $folder = public_path('image' . DIRECTORY_SEPARATOR . Str::camel($cliente->nombre_cliente));
                if (!\File::exists($folder)) {
                    \File::makeDirectory($folder, (int)$mode = 777, (bool)$recursive = true, (bool)$force = true);
                } else {
                    if (!is_writable($folder)) {
                        if (!chmod($folder)) {
                            Log::error("Cannot change the mode of file " . $folder . ")");
                            exit;
                        };
                    }
                }
                $files = File::allFiles($folder);

                foreach ($inputs as $key => $value) {
                    if (!is_null($value)) {
                        $filename = $key . '.' . $value->guessClientExtension();
                        $path     = '/image/' . Str::camel($cliente->nombre_cliente) . '/' . $filename;

                        foreach ($files as $file) {
                            if (File::exists((string)$file) && Str::contains((string)$file, $key)) {
                                File::delete((string)$file);
                            }
                        }

                        $value->move($folder, $filename);
                        $data = array_set($data, $key, $path);
                    }
                }
            }
            if (!is_null($data) || count($data)) {
                if (array_get($data, 'logo_header') == '') {
                    array_forget($data, 'logo_header');
                }
                if (array_get($data, 'logo_incentivo') == '') {
                    array_forget($data, 'logo_incentivo');
                }
            }
            $theme = $cliente->theme()->update($data);
        } catch (Exception $e) {
            throw $e;
        }

        return $theme;
    }

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

    public static function saveSurvey($data = array())
    {
        $survey = null;

        try {
            if (!is_null($data) || count($data)) {
                $data = array_add($data, 'id_estado', 1);
                array_forget($data, 'title');

                $validation = \Validator::make($data, \Encuesta::$rules, array(
                    'description.max' => 'La descripción no debe ser mayor que 220 caracteres.'
                ));

                if ($validation->passes()) {
                    $survey = \Encuesta::firstOrCreate($data);

                }
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $survey;
    }

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
        } else {
            if (Session::has('theme')) {
                $theme = Session::get('theme');
            }
        }

        Session::flush();


        return View::make('survey.messages')->withMessage($message)->withScript($script)->withTheme($theme)->withSurvey($survey);
    }

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
            } else {
                if (Session::has('theme')) {
                    $theme = Session::get('theme');
                }
            }

            return View::make('survey.errors')->withError($error)->withTheme($theme)->withSurvey($survey);
        } catch (Exception $e) {
            static::throwError($e);
        }
    }

    public function modifySurvey()
    {
        try {
            $inputs    = \Input::except(['_token', 'survey', 'plan']);
            $valid     = self::createBasicRules($inputs);
            $validator = \Validator::make(\Input::all(), $valid['rules'], $valid['messages']);

            if ($validator->fails()) {
                return \Redirect::back()->withErrors($validator)->withInput(\Input::except('_token'));
            }

            $encuesta   = Encuesta::find(Input::get('id_encuesta'));
            $questions  = $encuesta->preguntas;
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
                    $question->descripcion_1 = trim($ids[$question->id_pregunta_cabecera]);

                    if ($question->save()) {
                        $x++;
                    }
                }
            }

            $encuesta->description = Input::get('description');
            $encuesta->save();

            return Redirect::to('admin/encuesta/' . Input::get('id_encuesta') . '/edit');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

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

    public static function createQrCode($path, $info, $format = 'png', $size = 1080)
    {
        if (!\File::exists($path)) {
            \File::makeDirectory($path, 777, true, true);
        } else {
            if (!is_writable($path)) {
                $itWorked =chmod($path, 0755);

                if (!$itWorked) {
                    throw new Illuminate\Exception\Exception("Cannot change the mode of file " . $path . ")");
                }
            }
        }

        \QrCode::format($format)->errorCorrection('H')->size($size)->generate($info, $path);
    }

    public static function sendEmailNewUser($user = null)
    {
        if (isset($user)) {
            if (get_class($user) == 'Usuario') {
                $mail = array(
                    'email' => $user->correo_usuario,
                    'name'  => $user->nombre_usuario,
                );

                $data = array(
                    'nombre_usuario' => $user->nombre_usuario,
                    'usuario'        => $user->username,
                );
            }

            if (get_class($user) == 'CsUsuario') {
                $mail = array(
                    'email' => $user->email,
                    'name'  => $user->nombre,
                );

                $data = array(
                    'nombre_usuario' => $user->nombre,
                    'usuario'        => $user->usuario,
                );
            }

            if (!count($mail) && !count($data)) {
                return false;
            }

            if (!array_key_exists('email', $mail)) {
                return false;
            }

            if (!array_key_exists('subject', $mail)) {
                $subject = 'Bienvenido a CustomerExperience SCORE | CustomerTrigger.com';
                $mail    = array_add($mail, 'subject', $subject);
            }

            \Mail::send('emails.newUser', $data, function ($message) use ($mail) {
                $message->to($mail['email'], $mail['name'])
                        ->subject($mail['subject']);
//                        ->bcc('cristian.maulen@customertrigger.com', 'Cristian Maulen')
//                        ->bcc('pamela.donoso@customertrigger.com', 'Pamela Donoso');
            }, true);

            return true;
        }
    }
}
