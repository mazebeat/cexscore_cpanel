<?php

class PreguntaCabecerasController extends \ApiController {

	/**
	 * PreguntaCabecera Repository
	 *
	 * @var PreguntaCabecera
	 */
	protected $pregunta_cabecera;

	public function __construct(PreguntaCabecera $pregunta_cabecera)
	{
		$this->pregunta_cabecera = $pregunta_cabecera;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pregunta_cabeceras = $this->pregunta_cabecera->all();

		return View::make('admin.pregunta_cabeceras.index', compact('pregunta_cabeceras'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.pregunta_cabeceras.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, PreguntaCabecera::$rules);

		if ($validation->passes())
		{
			$this->pregunta_cabecera->create($input);

			return Redirect::route('admin.pregunta_cabeceras.index');
		}

		return Redirect::route('admin.pregunta_cabeceras.create')
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
		$pregunta_cabecera = $this->pregunta_cabecera->findOrFail($id);

		return View::make('admin.pregunta_cabeceras.show', compact('pregunta_cabecera'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pregunta_cabecera = $this->pregunta_cabecera->find($id);

		if (is_null($pregunta_cabecera))
		{
			return Redirect::route('admin.pregunta_cabeceras.index');
		}

		return View::make('admin.pregunta_cabeceras.edit', compact('pregunta_cabecera'));
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
		$validation = Validator::make($input, PreguntaCabecera::$rules);

		if ($validation->passes())
		{
			$pregunta_cabecera = $this->pregunta_cabecera->find($id);
			$pregunta_cabecera->update($input);

			return Redirect::route('admin.pregunta_cabeceras.show', $id);
		}

		return Redirect::route('admin.pregunta_cabeceras.edit', $id)
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
		$this->pregunta_cabecera->find($id)->delete();

		return Redirect::route('admin.pregunta_cabeceras.index');
	}

}
