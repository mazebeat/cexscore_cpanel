<?php

if (Config::get('app.debug_database')) {
    Event::listen('illuminate.query', function ($query) {
        $query     = DB::getQueryLog();
        $lastQuery = end($query);
        var_dump($lastQuery);
    });
}

ini_set('session.gc_maxlifetime', 3 * 60 * 60); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', false);
ini_set('session.use_only_cookies', true);
set_time_limit(180);

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

//GENERATE PDF FILES
Route::group(array('prefix' => 'pdf'), function () {
    Route::get('tarjeta', 'PdfController@getPdfTarjeta');
    Route::get('display', 'PdfController@getPdfDisplay');
    Route::get('encuesta', 'PdfController@getPdfEncuesta');

    Route::post('getZip', 'PdfController@getPdfCliente');
});

// TESTING
Route::get('test/test', function () {
    setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
    var_dump(\Str::title(strftime("%A, %d de %B de %Y")));
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
Route::get('test/report', function () {
    $account = Cliente::find(2);
    $start   = Carbon::now()->startOfWeek();
    $end     = Carbon::now()->endOfWeek();

    $file     = \Str::title(\Str::camel($account->nombre_cliente)) . '.pdf';
    $pathFile = public_path('temp' . DIRECTORY_SEPARATOR . $account->id_cliente . DIRECTORY_SEPARATOR);

    $realfile = $pathFile . $file;

    $dateRange = "Semana del {$start->day} al {$end->day} de " . \App\Util\Functions::convNumberToMonth($end->month) . " {$end->year}";

    return View::make('pdf.reporte')->with('account', $account)->with('dateRange', $dateRange);
});

Route::get('test/tempfile', function () {
    $account = Cliente::find(2);
    $start   = Carbon::now()->startOfWeek();
    $end     = Carbon::now()->endOfWeek();

    $file     = \Str::title(\Str::camel($account->nombre_cliente)) . '.pdf';
    $pathFile = public_path('temp' . DIRECTORY_SEPARATOR . $account->id_cliente . DIRECTORY_SEPARATOR);

    $realfile = $pathFile . $file;

    $dateRange = "Semana del {$start->day} al {$end->day} de " . \App\Util\Functions::convNumberToMonth($end->month) . " {$end->year}";

    $html = View::make('pdf.reporte')->with('account', $account)->with('dateRange', $dateRange)->render();

    // return View::make('pdf.reporte')->with('account', $account)->with('dateRange', $dateRange);

    $temp_file = tempnam(sys_get_temp_dir(), 'ReporteEjecutivo');
    // $temp_file = public_path('temp.html');

    $bytes_written = File::put($temp_file, $html);
    if ($bytes_written === false) {
        die("Error writing to file");
    }

    echo $temp_file;
//    $pdf = PDF::loadView('pdf.reporte', ['account' => $account, 'dateRange' => $dateRange]);
//    return $pdf->download('invoice.pdf');

//    return PDF::loadHTML($html, 'A4', 'portrait')->download('nombreArchivoPdf.pdf');

//    PDFS::loadHTML($html)->setPaper('a4')->setWarnings(false)->save('D:/myfile.pdf');
//    return $pdf->download('invoice.pdf');

//    return PDF::loadFile($temp_file)->save('/path-to/my_stored_file.pdf')->stream('download.pdf');


//    $pdf = App::make('dompdf');
//    $pdf->loadHTML($html)->save(public_path('nombreArchivoPdf.pdf'));
//    PDF::loadHTML($html)
//       ->setPaper('a4')
//       ->setOrientation('portrait')
//       ->stream(public_path('nombreArchivoPdf.pdf'));
});

Route::get('test/debug', function(){
    $controller = new PdfController;
    $cliente = Cliente::find(3);

    if($cliente){
        $directorioCliente = public_path('temp/'.$cliente->id_cliente.'/');

        $datos['cliente'] = $cliente->toArray();
        $datos['ubicacion'] = $controller->getUbicacionByCiudad($cliente->id_ciudad);
        $datos['apariencia'] = $cliente->apariencias()->first()->toArray();

        $urls = $cliente->urls()->first()->toArray();

        //if(!$urls->isEmpty()){
        try {
            //$datos['url'] = $urls->toArray();
            $datos['url'] = $urls;

            $nombreQR = $controller->generaQR($directorioCliente, $cliente->id_cliente, $datos['url']['id_momento'], url($datos['url']['given']));

            //$PDFsGenerados = $controller->procesaURLs($cliente, $urls, $datos, $directorioCliente);

            $datos['rutaQRAbsoluta'] = $directorioCliente.$nombreQR;
            $datos['URLrutaQR'] = 'temp/'.$cliente->id_cliente.'/'.$nombreQR;

            //$html = View::make('pdf.generador.display', $datos)->render();

            /*$textoFooter = '<p style="font-size:10pt;text-align:center;">';
            $textoFooter .= $cliente->direccion_cliente.', '.$datos['ubicacion']['ciudad'].' - '.$datos['ubicacion']['pais'].PHP_EOL;
            $textoFooter .= isset($cliente->fono_fijo_cliente) ? $cliente->fono_fijo_cliente : '';
            $textoFooter .= isset($cliente->fono_celular_cliente) ? ' | '.$cliente->fono_celular_cliente.PHP_EOL : isset($cliente->fono_fijo_cliente)? PHP_EOL : '';
            $textoFooter .= isset($cliente->correo_cliente) ? $cliente->correo_cliente.PHP_EOL : '';
            $textoFooter .= '</p>';*/
            $textoFooter = '<p style="font-family: Arial, sans-serif;font-size:10pt;text-align:center;">';
            $textoFooter .= $cliente->direccion_cliente.', '.$datos['ubicacion']['ciudad'].'<br/>'.$datos['ubicacion']['pais'].'<br/>';
            $textoFooter .= isset($cliente->fono_fijo_cliente) ? $cliente->fono_fijo_cliente : '';
            $textoFooter .= isset($cliente->fono_celular_cliente) ? ' | '.$cliente->fono_celular_cliente.'<br/>' : isset($cliente->fono_fijo_cliente)? '<br/>' : '';
            $textoFooter .= isset($cliente->correo_cliente) ? $cliente->correo_cliente.PHP_EOL : '';
            $textoFooter .= '</p>';

            $rutaPDF = $directorioCliente.'display_'.$cliente->id_cliente."_mom_".$datos['url']['id_momento'].".pdf";

            //$datos['footer'] = $textoFooter;

            //return View::make('pdf.generador.debug.display', $datos);

            $html = View::make('pdf.generador.display', $datos)->render();
            $pdf = PDF::loadHTML($html);

            $pdf->setOption('page-width', '14.5cm');
            $pdf->setOption('page-height', '21cm');
            $pdf->setOption('margin-left', '10mm');
            $pdf->setOption('margin-right', '10mm');
            $pdf->setOption('margin-top', '20mm');
            $pdf->setOption('margin-bottom', '20mm');
            //$pdf->setOption('footer-html', false);
            $pdf->setOption('footer-html', $textoFooter);

            //$pdf->save($rutaPDF);

            //return $rutaPDF;
            return $pdf->stream();
        }catch (Exception $e){
            //de alguna manera mostrar error
            //EncuestasClienteController::throwError($e);
            echo "error en try catch: <pre>";
            print_r($e);
        }
        //}else{
        //no hay urls registradas
        //echo "no hay urls registradas";
        //}
    }else{
        //no encontrado
        echo "cliente no encontrado";
    }

});