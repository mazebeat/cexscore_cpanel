<?php

ini_set('session.gc_maxlifetime', 3 * 60 * 60); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', false);
ini_set('session.use_only_cookies', true);


Route::get('/', function () {
    $error = new Illuminate\Support\MessageBag();
    $error->add('error', 'Página no encontrada');

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
        Route::resource('periodos', 'PeriodosController');
        // Password csusuario
        Route::get('usuarios/changePassword', 'UsuariosController@showChangePassword');
        Route::post('usuarios/changePassword/{id}', 'UsuariosController@changePassword');
        Route::post('usuarios/resetPassword/{id}', 'UsuariosController@resetPassword');
        // Password usuario
        Route::get('csusuarios/changePassword', 'CsUsuariosController@showChangePassword');
        Route::post('csusuarios/changePassword/{id}', 'CsUsuariosController@changePassword');
        Route::post('csusuarios/resetPassword/{id}', 'CsUsuariosController@resetPassword');
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

    $nps = Nps::where('fecha', Carbon::now())->lists('promedio');

    return AdminController::genNPS2($nps);
});