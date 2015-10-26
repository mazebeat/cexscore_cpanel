<?php

class TipoUsuariosController extends \ApiController {

	/**
	 * TipoUsuario Repository
	 *
	 * @var TipoUsuario
	 */
	protected $tipoUsuario;

	public function __construct(TipoUsuario $tipoUsuario)
	{
		$this->tipoUsuario = $tipoUsuario;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipoUsuarios = $this->tipoUsuario->all();

		return View::make('admin.tipoUsuarios.index', compact('tipoUsuarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.tipoUsuarios.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, TipoUsuario::$rules);

		if ($validation->passes())
		{
			$this->tipoUsuario->create($input);

			return Redirect::route('admin.tipoUsuarios.index');
		}

		return Redirect::route('admin.tipoUsuarios.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tipoUsuario = $this->tipoUsuario->findOrFail($id);

		return View::make('admin.tipoUsuarios.show', compact('tipoUsuario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipoUsuario = $this->tipoUsuario->find($id);

		if (is_null($tipoUsuario))
		{
			return Redirect::route('admin.tipoUsuarios.index');
		}

		return View::make('admin.tipoUsuarios.edit', compact('tipoUsuario'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, TipoUsuario::$rules);

		if ($validation->passes())
		{
			$tipoUsuario = $this->tipoUsuario->find($id);
			$tipoUsuario->update($input);

			return Redirect::route('admin.tipoUsuarios.show', $id);
		}

		return Redirect::route('admin.tipoUsuarios.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->tipoUsuario->find($id)->delete();

		return Redirect::route('admin.tipoUsuarios.index');
	}

}
