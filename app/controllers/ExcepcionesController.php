<?php

use MyProject\Proxies\__CG__\stdClass;

class ExcepcionesController extends \ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('csrf');
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse|string
	 */
	public function add()
	{
		try {
			if (Session::has('idcliente')) {
				$exception               = new ExcepcionUsuario();
				$exception->id_usuario   = Crypt::decrypt(Session::get('idcliente'));
				$exception->id_excepcion = 1;

				if ($exception->save()) {
					Session::flush();
					if (Request::ajax()) {
						return 'OK';
					}
				}

				$message        = new stdClass();
				$message->title = 'T� solicitud ha sido registrada, Gracias por tu Tiempo.';

				return Redirect::to('survey/success')->withMessage($message);
			}

			$error          = new stdClass();
			$error->code    = 401;
			$error->message = 'Cliente no encontrado.';

			return View::make('survey.error')->withError($error);

		} catch (Exception $e) {
			static::throwError($e);
		}
	}
}