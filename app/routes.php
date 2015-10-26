<?php

ini_set('session.gc_maxlifetime', 3 * 60 * 60); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', false);
ini_set('session.use_only_cookies', true);

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
        Route::resource('clientes', 'ClientesController');
        Route::resource('encuesta', 'EncuestasController');
        Route::resource('pais', 'PaisController');
        Route::resource('regions', 'RegionsController');
        Route::resource('ciudads', 'CiudadsController');
        Route::resource('momentoencuesta', 'MomentoencuestaController');
        Route::resource('apariencia', 'AparienciaController');
        Route::resource('usuarios', 'UsuariosController');
    });
});

Route::get('test/test', function () {
    $option = Input::get('option');
    $id     = Input::get('id');
});

route::get('find/locate', function () {
    $option   = Input::get('option');
    $filterBy = Input::get('filterBy');
    $list     = null;

    switch ($filterBy) {
        case 'ciudad':
            $list = Ciudad::where('id_region', $option)->lists('descripcion_ciudad', 'id_ciudad');
            break;
        case 'region':
            $list = Region::where('id_pais', $option)->lists('descripcion_region', 'id_region');
            break;
    }

    return $list;
});



