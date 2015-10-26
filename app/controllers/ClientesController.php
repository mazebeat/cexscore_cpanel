<?php

use Illuminate\Support\Facades\Input;
use SebastianBergmann\Exporter\Exception;

class ClientesController extends \ApiController
{

    public static function saveQuestions($data = array())
    {
        $id = null;

        if (!is_null($data) || count($data)) {
            try {
                $id = \PreguntaCabecera::insertGetId($data);
            } catch (\Exception $e) {
                throw $e;
            }
        }

        return $id;
    }

    /**
     * Display a listing of clientes
     *
     * @return Response
     */
    public function index()
    {
        $clientes = Cliente::all();

        return View::make('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new cliente
     *
     * @return Response
     */
    public function create()
    {
        $pais    = Pais::lists('descripcion_pais', 'id_pais');
        $plans   = Plan::lists('descripcion_plan', 'id_plan');
        $sectors = Sector::lists('descripcion_sector', 'id_sector');
        $states  = Estado::lists('descripcion_estado', 'id_estado');
        $catgs   = Categoria::select('descripcion_categoria')->orderBy('id_categoria')->lists('descripcion_categoria');


        return View::make('admin.clientes.create')->with('pais', $pais)->with('states', $states)->with('plans', $plans)->with('sectors', $sectors)->with('catgs', $catgs);
    }

    /**
     * Store a newly created cliente in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = array(
            'cliente.nombre_cliente'         => 'required|string',
            'cliente.rut_cliente'            => 'required|between:8,12|rut',
            'cliente.fono_fijo_cliente'           => 'required|between:7,16',
            'cliente.fono_delular_cliente'           => 'required|between:7,16',
            'cliente.correo_cliente'         => 'required|email',
            'cliente.pais'                   => 'required|',
            'cliente.region'                 => 'required|',
            'cliente.id_ciudad'              => 'required|',
            'cliente.id_sector'              => 'required|',
            'cliente.id_plan'                => 'required|',
            'apariencia.logo_header'         => 'required|image|max:700',
            'apariencia.logo_incentivo'      => 'required|image|max:700',
            'apariencia.color_header'        => 'required|',
            'apariencia.color_body'          => 'required|',
            'apariencia.color_footer'        => 'required|',
            'apariencia.color_boton'         => 'required|',
            'apariencia.color_opciones'      => 'required|',
            'apariencia.color_text_header'   => 'required|',
            'apariencia.color_text_body'     => 'required|',
            'apariencia.color_text_footer'   => 'required|',
            'apariencia.color_instrucciones' => 'required|',
            'apariencia.desea_captura_datos' => '',
            'encuesta.titulo'                => 'required|',
            'encuesta.slogan'                => 'required|',
            'encuesta.description'           => 'required|',
        );

        $messages = array(
            'cliente.nombre_cliente.required'         => '',
            'cliente.rut_cliente.required'            => '',
            'cliente.fono_fijo_cliente.required'           => '',
            'cliente.fono_celular_cliente.required'           => '',
            'cliente.correo_cliente.required'         => '',
            'cliente.pais.required'                   => '',
            'cliente.region.required'                 => '',
            'cliente.id_ciudad.required'              => '',
            'cliente.id_sector.required'              => '',
            'cliente.id_plan.required'                => '',
            'apariencia.logo_header.required'         => '',
            'apariencia.logo_incentivo.required'      => '',
            'apariencia.color_header.required'        => '',
            'apariencia.color_body.required'          => '',
            'apariencia.color_footer.required'        => '',
            'apariencia.color_boton.required'         => '',
            'apariencia.color_opciones.required'      => '',
            'apariencia.color_text_header.required'   => '',
            'apariencia.color_text_body.required'     => '',
            'apariencia.color_text_footer.required'   => '',
            'apariencia.color_instrucciones.required' => '',
            'apariencia.desea_captura_datos.required' => '',
            'encuesta.titulo.required'                => '',
            'encuesta.slogan.required'                => '',
            'encuesta.description.required'           => '',
        );

        $validator = Validator::make($data = Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $survey = self::saveSurvey(Input::get('encuesta'));
        $client = self::saveClient(Input::get('cliente'), $survey);
        $theme  = self::saveTheme(\Str::camel(Input::get('cliente.nombre_cliente')), Input::get('apariencia'), Input::file('apariencia'));
        $client->encuesta()->associate($survey);
        $client->save();

        return Redirect::route('admin.clientes.index');
    }

    /**
     * @param array $data
     *
     * @return null|static
     */
    public static function saveSurvey($data = array())
    {
        $survey = null;

        if (!is_null($data) || count($data)) {
            $data = array_add($data, 'id_estado', 1);

            try {
                $survey = \Encuesta::firstOrCreate($data);
                \PreguntaCabecera::generateDefaultQuestions($survey);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $survey;
    }

    /**
     * @param $data
     * @param $survey
     *
     * @return null|static
     * @throws \Exception
     */
    public static function saveClient($data, $survey)
    {
        $client = null;

        if (!is_null($data) || count($data)) {
            array_forget($data, 'pais');
            array_forget($data, 'region');
            $data = array_add($data, 'id_encuesta', $survey->id_encuesta);
            $data = array_add($data, 'id_estado', 1);

            try {
                $client = \Cliente::firstOrCreate($data);
            } catch (\Exception $e) {
                throw $e;
            }
        }

        return $client;
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

        if (!is_null($data) || count($data)) {
            // $logoHeader = array_get($inputs, 'logo_header');
            // $logoHeader = array_get($inputs, 'logo_incentivo');

            // Mover archivos a las carpetas
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

            array_get($data, 'desea_captura_datos') == 'on' ? array_set($data, 'desea_captura_datos', true) : array_set($data, 'desea_captura_datos', false);

            $theme = \Apariencia::firstOrCreate($data);
        }

        return $theme;
    }

    /**
     * Display the specified cliente.
     *
     * @param  int $i .requiredd => '',
     *
     * @return Response
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);

        return View::make('admin.clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified cliente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pais    = Pais::lists('descripcion_pais', 'id_pais');
        $plans   = Plan::lists('descripcion_plan', 'id_plan');
        $sectors = Sector::lists('descripcion_sector', 'id_sector');
        $states  = Estado::lists('descripcion_estado', 'id_estado');
        $catgs   = Categoria::select('descripcion_categoria')->orderBy('id_categoria')->lists('descripcion_categoria');
        $ciudads = Ciudad::lists('descripcion_ciudad', 'id_ciudad');
        $cliente = Cliente::find($id);

        return View::make('admin.clientes.edit', compact('cliente'))->with('pais', $pais)->with('states', $states)->with('plans', $plans)
            ->with('sectors', $sectors)
            ->with('ciudads', $ciudads)
            ->with('catgs', $catgs);
    }

    /**
     * Update the specified cliente in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $cliente = Cliente::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Cliente::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $cliente->update($data = array());

        return Redirect::route('admin.clientes.index');
    }

    /**
     * Remove the specified cliente from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        Cliente::destroy($id);

        return Redirect::route('admin.clientes.index');
    }

    /**
     * @return \Encuesta|null
     * @throws \Exception
     */
    public function loadSurvey()
    {
        try {
            $client = \Auth::user()->cliente;
            $survey = null;
            $plan   = $client->plan;

            if (!is_null($plan)) {
                $idplan = $plan->id_plan;
                $survey = $client->encuesta;

                if (is_null($survey)) {
                    throw new \Exception('Cliente no tiene encuesta');
                }

                return $survey;
            }

            throw new \Exception('Cliente no tiene plan');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     *
     */
    public function createClient()
    {
        // Create survey
        $survey = \Encuesta::create(['id_estado' => 1]);

        // Generate default questions
        \PreguntaCabecera::generateDefaultQuestions($survey);

        // Create client
        $client = \Cliente::firstOrCreate([
            'rut_cliente'       => \Input::get('rut_cliente'),
            'nombre_cliente'    => \Input::get('nombre_cliente'),
            'fono_fijo_cliente'      => \Input::get('fono_fijo_cliente'),
            'fono_celular_cliente'      => \Input::get('fono_celular_cliente'),
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
            $idencuesta = \Crypt::decrypt(\Input::get('survey'));
            $idplan     = \Crypt::decrypt(\Input::get('plan'));
            $x          = 0;

            if ($idplan == 1) {
                $errors = new \MessageBag();
                $errors->add('inesperado', 'No mantiene los privilegios para modificar');

                return \Redirect::back()->withErrors($errors)->withInput(\Input::except('_token'));
            }

            if (count($inputs) <= 0) {
                $errors = new \MessageBag();
                $errors->add('inesperado', 'Cantidad de textos incorrecta');

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

            if ($x != 4) {
                $errors = new MessageBag();
                $errors->add('inesperado', 'Error al procesar solicitud');

                return Redirect::back()->withErrors($errors)->withInput(Input::except('_token'));
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
                    $messages[$key . '.required'] = 'El texto en la pregunta ' . $count++ . ' es obligatorio';
                }
            }

            return array('rules' => $rules, 'messages' => $messages);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
