<?php


class CuentasController extends \ApiController
{
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
     * Display a listing of cuentas
     *
     * @return Response
     */
    public function index()
    {
        $cuentas = Cliente::all();

        return View::make('admin.cuentas.index', compact('cuentas'));
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
        $canals  = Canal::lists('descripcion_canal', 'id_canal');
        $sectors = Sector::lists('descripcion_sector', 'id_sector');
        $catgs   = Categoria::select('descripcion_categoria')->orderBy('id_categoria')->lists('descripcion_categoria');

        return View::make('admin.cuentas.create')->with('pais', $pais)->with('canals', $canals)->with('plans', $plans)->with('sectors', $sectors)->with('catgs', $catgs);
    }

    /**
     * Store a newly created cliente in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules    = array(
            'cliente.nombre_cliente'         => 'required|string',
            'cliente.nombre_legal_cliente'   => 'string',
            'cliente.rut_cliente'            => 'required|between:8,12|rut',
            'cliente.fono_fijo_cliente'      => 'required|between:7,16',
            'cliente.fono_celular_cliente'   => 'required|between:7,16',
            'cliente.correo_cliente'         => 'required|email',
            'cliente.pais'                   => 'required|',
            'cliente.region'                 => '',
            'cliente.id_ciudad'              => '',
            'cliente.id_sector'              => 'required|',
            'cliente.id_encuesta'            => 'required|',
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
            'encuesta.titulo'                => 'required|',
            'encuesta.slogan'                => '',
            'encuesta.description'           => '',
        );
        $required = ' es requerido.';

        $messages  = array(
            'cliente.nombre_cliente.required'         => 'El campo nombre' . $required,
            'cliente.nombre_legal_cliente.required'   => 'El campo nombre legal' . $required,
            'cliente.rut_cliente.required'            => 'El campo RUT' . $required,
            'cliente.fono_fijo_cliente.required'      => 'El campo fono fijo' . $required,
            'cliente.fono_celular_cliente.required'   => 'El campo fono celular' . $required,
            'cliente.correo_cliente.required'         => 'El campo e-mail' . $required,
            'cliente.pais.required'                   => 'El campo pais' . $required,
            'cliente.region.required'                 => 'El campo region' . $required,
            'cliente.id_ciudad.required'              => 'El campo ciudad' . $required,
            'cliente.id_sector.required'              => 'El campo sector' . $required,
            'cliente.id_plan.required'                => 'El campo plan' . $required,
            'apariencia.logo_header.required'         => 'El campo imagen logo' . $required,
            'apariencia.logo_incentivo.required'      => 'El campo imagen incentivo' . $required,
            'apariencia.color_header.required'        => 'El campo color header' . $required,
            'apariencia.color_body.required'          => 'El campo color body' . $required,
            'apariencia.color_footer.required'        => 'El campo color footer' . $required,
            'apariencia.color_boton.required'         => 'El campo color botón' . $required,
            'apariencia.color_opciones.required'      => 'El campo color opciones' . $required,
            'apariencia.color_text_header.required'   => 'El campo color texto header' . $required,
            'apariencia.color_text_body.required'     => 'El campo color texto body' . $required,
            'apariencia.color_text_footer.required'   => 'El campo color texto footer' . $required,
            'apariencia.color_instrucciones.required' => 'El campo color instrucciones' . $required,
            'encuesta.titulo.required'                => 'El campo título' . $required,
            'encuesta.slogan.required'                => 'El campo subtitulo' . $required,
            'encuesta.description.required'           => 'El campo descripcion encuesta' . $required,
        );
        $data      = Input::all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $survey = Encuesta::find(Input::get('cliente.id_encuesta')); // self::saveSurvey(Input::get('encuesta'));
            if (!is_null($survey)) {
                $client  = self::saveClient(Input::get('cliente'), $survey);
                $user    = self::saveAdministrator(Input::get('usuario'), $client, $survey);
                $moments = self::saveMoments(Input::get('momentos'));
                $theme   = self::saveTheme(Str::camel(Input::get('cliente.nombre_cliente')), Input::get('apariencia'), Input::file('apariencia'));
                $client->encuesta()->associate($survey);
                $client->save();

                $urls = Url::whereIdCliente($client->id_cliente)->get(['given', 'id_momento', 'id_cliente'])->toArray();

                foreach ($urls as $k => $v) {
                    array_set($urls[$k], 'given', url($v['given']));
                    $urls[$k] = array_add($urls[$k], 'descripcion_momento',
                        MomentoEncuesta::where('id_cliente', $v['id_cliente'])->where('id_momento', $v['id_momento'])->first()->descripcion_momento);
                }

                if ($client->save()) {
                    self::sendWelcomeMail(array(
                        'email' => $user->usuario,
                        'name'  => 'Lar',
                    ), array(
                        'nombre_usuario' => $user->usuario,
                        'usuario'        => $user->usuario,
                        'urls'           => $urls,
                    ));
                }

                return Redirect::route('admin.cuentas.index');
            }

            $error = new MessageBag(['Sector sin encuesta definida']);

            return Redirect::back()->withErrors($error)->withInput();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public static function sendWelcomeMail($mail = array(), $data = array())
    {
        if (count($mail) || count($data)) {
            return false;
        }

        if (!array_key_exists('subject', $mail)) {
            $subject = 'Bienvenido a CustomerExperience SCORE | CustomerTrigger.com';
            $mail    = array_add($mail, 'subject', $subject);
        }

        if (!array_key_exists('email', $mail)) {
            return false;
        }
        // $datas = [
        //      'email'   => 'asanmartin@intelidata.cl',
        //      'name'    => 'Lar',
        //      'subject' => $subject,
        // ];

        Mail::queue('emails.bienvenida', $data, function ($message) use ($mail) {
            $message->to($mail['email'], $mail['name'])->cc('diego.pintod@gmail.com')->subject($mail['subject']);
        });

        return true;
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

        return View::make('admin.cuentas.show', compact('cliente'));
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
        //        $momentoencuestum = $cliente->encuesta->momentos;
        $momentoencuestum = MomentoEncuesta::where('id_encuesta', $cliente->encuesta->id_encuesta)->where('id_cliente', $cliente->id_cliente)->get();

        return View::make('admin.cuentas.edit', compact('cliente'))->with('pais', $pais)->with('states', $states)->with('plans', $plans)->with('sectors', $sectors)->with('ciudads',
            $ciudads)->with('catgs', $catgs)->with('momentoencuestum', $momentoencuestum);
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
        if (!Input::has('accion')) {
        }

        switch (Input::get('accion')) {
            case 'update.account':
                $validator = Validator::make(Input::all(), Cliente::$rules['update']);

                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                }

                $cliente->update(Input::all());

                break;
            case 'update.plan':
                break;
            case 'update.moments':
                self::saveMoments(Input::only('momentos'), $cliente);
                break;
        }


        return Redirect::route('admin.cuentas.edit', [$id]);
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

        return Redirect::route('admin.cuentas.index');
    }

    /**
     * @return \Encuesta|null
     * @throws Exception
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
                    throw new Exception('Cliente no tiene encuesta');
                }

                return $survey;
            }

            throw new Exception('Cliente no tiene plan');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     *
     */
    public function createClient()
    {
        try {
            // Create survey
            $survey = \Encuesta::create(['id_estado' => 1]);

            // Generate default questions
            \PreguntaCabecera::generateDefaultQuestions($survey);

            // Create client
            $client = \Cliente::firstOrCreate([
                'rut_cliente'          => \Input::get('rut_cliente'),
                'nombre_cliente'       => \Input::get('nombre_cliente'),
                'fono_fijo_cliente'    => \Input::get('fono_fijo_cliente'),
                'fono_celular_cliente' => \Input::get('fono_celular_cliente'),
                'correo_cliente'       => \Input::get('correo_cliente'),
                'direccion_cliente'    => \Input::get('direccion_cliente'),
                'id_sector'            => \Input::get('sector'), // ????
                'id_ciudad'            => \Input::get('ciudad'),
                'id_tipo_cliente'      => \Input::get(''), // 1
                'id_plan'              => \Input::get('plan'),
            ]);

            // Assciate survey to client
            $client->encuesta()->associate($survey);
            $client->save();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function resumen($id)
    {
        return View::make('admin.cuentas.resumen')->with('resumen', Cliente::clientResumen($id));
    }
}
