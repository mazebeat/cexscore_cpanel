<?php

//ini_set('session.gc_maxlifetime', 3 * 60 * 60); // 3 hours
//ini_set('session.gc_probability', 1);
//ini_set('session.gc_divisor', 100);
//ini_set('session.cookie_secure', false);
//ini_set('session.use_only_cookies', true);


Route::get('/', function () {
    $error = new Illuminate\Support\MessageBag();
    $error->add('error', 'P�gina no encontrada');

    return View::make('survey.errors')->withErrors($error)->withCode('500');
});
// SHORTEN ROUTES
Route::get('{shorten}', 'ShortenController@getShorten');
// SURVEY ROUTES
Route::group(array('prefix' => 'survey'), function () {
    Route::get('{idcliente}/{canal}/{momento}', 'EncuestasClienteController@index');
    Route::post('store', 'EncuestasClienteController@store');
    Route::get('politicas', 'PoliticasController@index');
    Route::get('addexception', 'ExcepcionesController@add');
    Route::get('success', 'ApiController@generateMessage');
    Route::get('error', 'ApiController@generateError');
});
//ADMINISTRATOR
Route::group(array('prefix' => 'admin'), function () {
    Route::get('login/{idcliente?}', 'AdminController@index');
    Route::post('/', 'AdminController@login');
    Route::group(array('before' => 'auth'), function () {
        Route::get('logout', 'AdminController@logout');
        Route::get('cpanel', 'AdminController@cpanel');
        Route::group(array('prefix' => 'shorten'), function () {
            Route::post('/', 'ShortenController@postShorten');
            Route::get('generate', 'ShortenController@index');
        });
        Route::group(array('prefix' => 'survey'), function () {
            Route::get('load', 'AdminController@loadSurvey');
            Route::post('load', 'AdminController@modifySurvey');
        });
        Route::resource('plans', 'PlansController');
        Route::resource('sectors', 'SectorsController');
        Route::resource('tipousuarios', 'TipoUsuariosController');
        Route::resource('momentos', 'MomentosController');
        Route::resource('canals', 'CanalsController');
        Route::resource('cuentas', 'CuentasController');
        Route::get('cuentas/{id?}/resumen', 'CuentasController@resumen');
        Route::resource('encuesta', 'EncuestasController');
        Route::resource('pais', 'PaisController');
        Route::resource('regions', 'RegionsController');
        Route::resource('ciudads', 'CiudadsController');
        Route::resource('momentoencuesta', 'MomentoEncuestaController');
        Route::resource('apariencia', 'AparienciaController');
        Route::resource('usuarios', 'UsuariosController');
        Route::resource('csusuarios', 'CsUsuariosController');
        Route::post('usuarios/resetPassword/{id?}', 'UsuariosController@resetPassword');
        Route::post('csusuarios/resetPassword/{id?}', 'CsUsuariosController@resetPassword');
        Route::resource('periodos', 'PeriodosController');
    });
    Route::group(array('prefix' => 'find'), function () {
        route::get('locate', function () {
            $option   = Input::get('option');
            $filterBy = Input::get('filterBy');
            $list     = null;

            switch ($filterBy) {
                case 'region':
                    $list = Ciudad::where('id_region', $option)->lists('descripcion_ciudad', 'id_ciudad');
                    break;
                case 'pais':
                    $list = Region::where('id_pais', $option)->lists('descripcion_region', 'id_region');
                    break;
            }

            return $list;
        });
        Route::get('configplan', function () {
            $idPlan = Input::get('idplan', null);
            $plan   = null;

            if (!is_null($idPlan)) {
                $plan = Plan::find($idPlan)->cantidad_momentos_plan;

                if (is_null($plan)) {
                    $plan = 0;
                }
            }

            return $plan;
        });
        Route::get('survey', function () {
            $id = Input::get('id_sector');

            $result = EncuestaSector::whereIdSector($id)->first();

            if (is_null($result)) {
                return null;
            }

            return Response::json(['id' => $result->encuesta->id_encuesta, 'preguntas' => $result->encuesta->preguntas]);
        });
        Route::get('cpanel', function () {
            return Response::json(array(
                'totalClients'  => Cliente::all()->count(),
                'totalUsers'    => CsUsuario::all()->count(),
                'totalPlans'    => Plan::all()->count(),
                'clientsByPlan' => Cliente::clientsByPlan(),
                'countClients'  => Cliente::countClients(),
                'npsTable'      => AdminController::npsTable(),
            ), 200);
        });
    });
});
// TESTING
Route::get('test/test', function () {
    //    dd('tester');

    try {
        $user = User::findOrFail(11);
    }
    catch (ModelNotFoundException $e) {
        App::abort(404, 'Error al realizar acción');
        dd(get_class_methods($e));
        dd($e);
    }

    $cliente = Cliente::find(2);
    $r       = $cliente->encuesta->momentos->all();
    //    $r = MomentoEncuesta::where('id_encuesta', $cliente->encuesta->id_encuesta)->where('id_cliente', $cliente->id_cliente)->get();
    dd($r[0]->pivot->descripcion_momento);


    //    dd(Momento::find(2));
    //    $r = Auth::user()->cliente->encuesta->momentos()->save(Momento::find(2), array('descripcion_momento' => 'aaaaaaaaaaa'));
    //    $r = Auth::user()->cliente->id_cliente;
    //    dd($r);
    //    $r = Cliente::find(2)->encuesta->momentos->all();
    //    foreach($r as $k => $v) {
    //        dd($v->pivot->descripcion_momento);
    //    }
    //    $r->pivot->descripcion_momento = "Chao ";
    //    $r->pivot->save();

    $r = Cliente::clientResumen(2);
    $r = CsUsuario::responsable()->where('id_cliente', 2)->first()->toArray();

    dd($r);

    $urls = Url::whereIdCliente(2)->get(['given', 'id_momento', 'id_cliente'])->toArray();

    foreach ($urls as $k => $v) {
        array_set($urls[$k], 'given', url($v['given']));
        $urls[$k] = array_add($urls[$k], 'descripcion_momento', MomentoEncuesta::where('id_cliente', $v['id_cliente'])->where('id_momento', $v['id_momento'])->first()->descripcion_momento);
    }

    $data = [
        'nombre_usuario' => 'User Tester',
        'usuario'        => 'usernaame.user',
        'urls'           => $urls,
    ];

    $datas = [
        'email'      => 'dpinto@intelidata.cl',
        'first_name' => 'Lar',
        'from'       => 'sample@sample.comt',
        'from_name'  => 'Vel',
    ];

    Mail::queue('emails.bienvenida', $data, function ($message) use ($datas) {
        $message->to($datas['email'])->cc('diego.pintod@gmail.com')->subject('Bienvenido a CustomerExperience SCORE | CustomerTrigger.com');
    });
});