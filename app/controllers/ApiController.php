<?php

use Illuminate\Support\Facades\Session;
use SebastianBergmann\Exporter\Exception;

class ApiController extends \BaseController
{
    protected $view_params = array();
    private   $errors      = array();

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        if (Session::has('err')) {
            $this->errors             = Session::get('err');
            $this->view_params['err'] = $this->errors;
        }
    }

    /**
     * @param $input
     *
     * @return bool
     */
    public static function objectHasProperty($input)
    {
        return (is_object($input) && array_filter(get_object_vars($input), function ($val) {
                return (is_string($val) && strlen($val)) || ($val !== null);
            })) ? true : false;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateMessage()
    {
        $theme  = null;
        $survey = null;
        if (!Session::has('message') || !is_object(Session::get('message'))) {
            $message           = new stdClass();
            $message->title    = Str::hes('&iexcl;Agradecemos sus Respuestas&#33;');
            $message->subtitle = '';
        } else {
            $message = Session::get('message');
        }

        //$script = "setTimeout('window.location.href=\"" . URL::to('/') . "/\";', 5000); if (typeof window.event == 'undefined'){ document.onkeypress = function(e){ var test_var=e.target.nodeName.toUpperCase(); if (e.target.type) var test_type=e.target.type.toUpperCase(); if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA'){ return e.keyCode; }else if (e.keyCode == 8 || e.keyCode == 116 || e.keyCode == 122){ e.preventDefault(); } } }else{ document.onkeydown = function(){ var test_var=event.srcElement.tagName.toUpperCase(); if (event.srcElement.type) var test_type=event.srcElement.type.toUpperCase(); if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA'){ return event.keyCode; } else if (event.keyCode == 8 || e.keyCode == 116 || e.keyCode == 122){ event.returnValue=false; } } } ";
        $script = '';

        if (Session::has('survey-theme')) {
            $theme = Session::get('survey-theme');
        } else if (Session::has('theme')) {
            $theme = Session::get('theme');
        }

        return View::make('survey.messages')->withMessage($message)->withScript($script)->withTheme($theme)->withSurvey($survey);
    }

    /**
     * @return mixed
     */
    public function generateError()
    {
        try {
            if (!Session::has('error') || !is_object(Session::get('error'))) {
                $error          = new stdClass();
                $error->code    = 401;
                $error->message = 'Error Inesperado.';
            } else {
                $error = Session::get('error');
            }
            $survey = null;
            $theme  = null;

            if (Session::has('survey-theme')) {
                $theme = Session::get('survey-theme');
            } else if (Session::has('theme')) {
                $theme = Session::get('theme');
            }

            return View::make('survey.errors')->withError($error)->withTheme($theme)->withSurvey($survey);
        } catch (Exception $e) {
            static::throwError($e);
        }
    }

    /**
     * @param \SebastianBergmann\Exporter\Exception $e
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function throwError(Exception $e)
    {
        if (!Config::get('app.debug')) {
            $error          = new stdClass();
            $error->code    = $e->getCode();
            $error->message = $e->getMessage();

            return Redirect::to('survey/error')->with('error', $error);
        }

        throw $e;
    }

    protected function setError($str)
    {
        if (!isset($this->view_params['err']) || $this->view_params['err'] == null) {
            $this->view_params['err'] = array();
        }
        if (!isset($this->errors) || $this->errors == null) {
            $this->errors = array();
        }
        array_push($this->view_params['err'], $str);
        array_push($this->errors, $str);
        Session::put('err', $this->errors);
    }

    protected function getErrors()
    {
        return $this->errors;
    }
}
