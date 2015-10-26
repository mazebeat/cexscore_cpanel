<?php

use SebastianBergmann\Exporter\Exception;

class ShortenController extends \ApiController
{
	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('csrf');
	}

	public function index()
	{
		//if(Session::has('idcliente'))
		//{
		//	$clients = Cliente::find(Session::get('idcliente');
		//	if()
		$clients = Cliente::where('id_cliente', '!=', Config::get('default.idcliente'))->lists('nombre_cliente', 'id_cliente');
		//}
		$clients = Cliente::lists('nombre_cliente', 'id_cliente');
		$canals  = Canal::lists('descripcion_canal', 'codigo_canal');
		$moments = Momento::lists('descripcion_momento', 'id_momento');

		return View::make('admin.shorturl.home')->withClients($clients)->withCanals($canals)->withMoments($moments);
	}

	public function getShorten($given = null)
	{
		try {
			if (is_null($given)) {
				return Redirect::to('survey/error');
			}

			$row = Url::whereGiven($given)->first();

			if (is_null($row) || !$row->exists) {
				return Redirect::to('survey/error');
			}

			return Redirect::to($row->url);

		} catch (Exception $e) {
			static::throwError($e);
		}
	}

	public function postShorten()
	{
		$url   = Input::get('url', null);
		$rules = array('url' => 'required|url');

		try {
			if (!isset($url) || $url == '') {
				$url   = '/survey' . '/' . Crypt::encrypt(Input::get('client', null)) . '/' . Crypt::encrypt(Input::get('canal', null)) . '/' . Crypt::encrypt(Input::get('momento', null));
				// $url   = url('/survey', [Crypt::encrypt(Input::get('client', null)), Crypt::encrypt(Input::get('canal', null)), Crypt::encrypt(Input::get('momento', null))]);
				$rules = ['client' => 'required|integer', 'canal' => 'required|min:2', 'momento' => 'required'];
			}

			$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput(Input::except('_token'));
			}

			$record = Url::whereUrl($url)->first();

			if (isset($record) && $record->exists) {
				$url = '/' . $record->given;
				// $url = url('/', [$record->given]);				

				return View::make('admin.shorturl.result')->with('url', $url);
			}

			$canal            = Canal::whereCodigoCanal(Input::get('canal'))->first();
			$data             = new Url;
			$data->url        = $url;
			$data->given      = Url::getShortenedUrl();
			$data->id_cliente = Input::get('client');
			$data->id_canal   = $canal->id_canal;
			$data->id_momento = Input::get('momento');
			//$data->params = implode('|', Input::except('_token'));
			if ($data->save()) {
				$row = Url::whereUrl($url)->first();
				$url = '/' . $row->given;
				// $url = url('/', [$row->given]);				

				return View::make('admin.shorturl.result')->with('url', $url);
			}

		} catch (Exception $e) {
			static::throwError($e);
		}
	}
}