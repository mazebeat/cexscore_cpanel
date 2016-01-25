<?php

//// Display all SQL executed in Eloquent
//Event::listen('illuminate.query', function ($query) {
//    //    var_dump($query);
//    $query     = DB::getQueryLog();
//    $lastQuery = end($query);
//    var_dump($lastQuery);
//});

ini_set('session.gc_maxlifetime', 3 * 60 * 60); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', false);
ini_set('session.use_only_cookies', true);

Route::get('/', 'HomeController@index');

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
        route::get('locate', 'AdminController@locate');
        Route::get('configplan', 'AdminController@configplan');
        Route::get('survey', 'AdminController@surveyGet');
        Route::get('cpanel', 'AdminController@cpanelIndex');
    });
});

// TESTING
Route::get('test/test', function () {
    setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
    var_dump(\Str::title(strftime("%B")));
});
Route::get('test/env', function () {
    var_dump(App::environment());
});
Route::get('test/db', function () {
    var_dump(Config::get('database.default'), Config::get('database.connections.' . Config::get('database.default') . '.host'));
});
Route::get('test/info', function () {
    var_dump(phpinfo());
});