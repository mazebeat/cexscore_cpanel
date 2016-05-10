<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(
    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/utils',
    app_path() . '/database/seeds',
));


/*
|--------------------------------------------------------------------------
| Custom Validator
|--------------------------------------------------------------------------
|
|
|
|
|
*/

Validator::resolver(function ($translator, $data, $rules, $messages) {
    return new App\Util\CustomValidator($translator, $data, $rules, $messages);
});

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

if (Config::get('config.logs.path') != '') {
    if (!File::exists(Config::get('config.logs.path'))) {
        // File::makeDirectory(Config::get('config.logs.path'), 777, true, true);
        if (!mkdir(Config::get('config.logs.path'), 0777, true)) {
            Log::error("Fallo al crear las carpetas... (". Config::get('config.logs.path') .")");
            exit(1);
        }
    } else {
        if (!is_writable(Config::get('config.logs.path'))) {
            if (!@chmod(Config::get('config.logs.path'), 775)) {
                Log::error("Cannot change the mode of file " . Config::get('config.logs.path') . ")");
                exit;
            };
        }
    }

    $log = Config::get('config.logs.path') . DIRECTORY_SEPARATOR . 'PanelCExScore.log';
} else {
    $log = storage_path() . '/logs/PanelCExScore.log';
}

//Log::useFiles(storage_path() . '/logs/laravel.log');
Log::useFiles($log);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

use Illuminate\Database\Eloquent\ModelNotFoundException;

App::error(function (ModelNotFoundException $exception) {
    Log::error($exception);

    return Response::make('No encontrado [ERROR]: ' . $exception->getMessage(), 404);
});

App::error(function (Exception $exception, $code) {
    Log::error($exception);
});

App::missing(function ($exception) {
    Log::warning($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function () {
    Log::warning('App down!...');

    return Response::make("<h3>Estamos en mantención,</h3><h1>Pronto Volveremos!</h1>", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path() . '/filters.php';
require app_path() . '/utils/Macros.php';