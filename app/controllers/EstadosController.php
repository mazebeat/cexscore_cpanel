<?php

class EstadosController extends \ApiController {

	/**
	 * Estado Repository
	 *
	 * @var Estado
	 */
	protected $estado;

	public function __construct(Estado $estado)
	{
		$this->estado = $estado;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$estados = $this->estado->all();

		return View::make('admin.estados.index', compact('estados'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.estados.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Estado::$rules);

		if ($validation->passes())
		{
			$this->estado->create($input);

			return Redirect::route('admin.estados.index');
		}

		return Redirect::route('admin.estados.create')
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
		$estado = $this->estado->findOrFail($id);

		return View::make('admin.estados.show', compact('estado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$estado = $this->estado->find($id);

		if (is_null($estado))
		{
			return Redirect::route('admin.estados.index');
		}

		return View::make('admin.estados.edit', compact('estado'));
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
		$validation = Validator::make($input, Estado::$rules);

		if ($validation->passes())
		{
			$estado = $this->estado->find($id);
			$estado->update($input);

			return Redirect::route('admin.estados.show', $id);
		}

		return Redirect::route('admin.estados.edit', $id)
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
		$this->estado->find($id)->delete();

		return Redirect::route('admin.estados.index');
	}

}
