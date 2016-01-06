<?php

class HomeController extends \ApiController
{

    public function index()
    {
        $error = new Illuminate\Support\MessageBag();
        $error->add('error', 'Página no encontrada');

        return View::make('survey.errors')->withErrors($error)->withCode('500');
    }

}