<?php

class AparienciaController extends \ApiController {

	/**
	 * Apariencia Repository
	 *
	 * @var Apariencia
	 */
	protected $apariencium;

	public function __construct(Apariencia $apariencium)
	{
		$this->apariencium = $apariencium;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$apariencia = $this->apariencium->all();

		return View::make('admin.apariencia.index', compact('apariencia'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.apariencia.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Apariencia::$rules);

		if ($validation->passes())
		{
			$this->apariencium->create($input);

			return Redirect::route('admin.apariencia.index');
		}

		return Redirect::route('admin.apariencia.create')
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
		$apariencium = $this->apariencium->findOrFail($id);

		return View::make('admin.apariencia.show', compact('apariencium'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$apariencium = $this->apariencium->find($id);

		if (is_null($apariencium))
		{
			return Redirect::route('admin.apariencia.index');
		}

		return View::make('admin.apariencia.edit', compact('apariencium'));
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
		$validation = Validator::make($input, Apariencia::$rules);

		if ($validation->passes())
		{
			$apariencium = $this->apariencium->find($id);
			$apariencium->update($input);

			return Redirect::route('admin.apariencia.show', $id);
		}

		return Redirect::route('admin.apariencia.edit', $id)
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
		$this->apariencium->find($id)->delete();

		return Redirect::route('admin.apariencia.index');
	}

}
