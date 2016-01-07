<?php

class HomeController extends \ApiController
{

    public function index()
    {
        Log::error('Página no encontrada: ' . Request::url());

        $error = new Illuminate\Support\MessageBag();
        $error->add('error', 'Página no encontrada');

        return View::make('survey.errors')->withErrors($error)->withCode('500');
    }

}