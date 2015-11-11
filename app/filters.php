<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request) {
    //
});


App::after(function ($request, $response) {
    // if (!Config::get('app.debug')) {
//    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
//        $response->header('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
//    }
    // }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function () {
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            //			return Redirect::guest('admin/login');
            //$msg = array('data'    => array('type'  => 'danger',
            //                                'title' => 'Atención',
            //                                'text'  => 'Usuario no logueado'),
            //             'options' => array('left' => HTML::link(URL::to('/'), 'Salir', array('class' => 'col-md-3 btn btn-default btn-lg pull-right text-uppercase'))));
            //$message           = new \stdClass();
            //$message->title    = 'Atención';
            //$message->subtitle = 'Usuario no logueado';
            //
            //return View::make('survey.messages')->withMessage($message);

            return Redirect::to('admin/login');
        }
    }
});

Route::filter('auth.basic', function () {
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) {
        return Redirect::to('admin/login');
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function ($route, $request) {
    if (strtoupper($request->getMethod()) === 'GET') {
        return;
    }

    $token = $request->header('X-CSRF-Token') ?: Input::get('_token');

    if (Session::token() != $token) {
        try {
            return Redirect::back();
        } catch (Illuminate\Session\TokenMismatchException $exception) {
            Log::error($exception);
            throw new Illuminate\Session\TokenMismatchException;
        }
    }
});

// Route::filter('csrf', function () {
// 	if (Request::getMethod() !== 'GET' && Session::token() != Input::get('_token')) {
// 		throw new Illuminate\Session\TokenMismatchException;
// 	}
// });