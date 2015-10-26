<?php

use SebastianBergmann\Exporter\Exception;

class PoliticasController extends \ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('csrf');
	}

	/**
	 * @return mixed
	 */
	public function index()
	{
		try {
			$theme = null;
			if (Session::has('survey-theme')) {
				$theme = Session::get('survey-theme');
			}

			$survey = null;
			if (Session::has('survey-survey')) {
				$survey = Session::get('survey-survey');
			}

			return View::make('survey.politicas')->withTheme($theme)->withSurvey($survey);
		} catch (Exception $e) {
			static::throwError($e);
		}
	}
}
