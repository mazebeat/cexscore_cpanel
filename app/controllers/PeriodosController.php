<?php

class PeriodosController extends BaseController {

	/**
	 * Periodo Repository
	 *
	 * @var Periodo
	 */
	protected $periodo;

	public function __construct(Periodo $periodo)
	{
		$this->periodo = $periodo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$periodos = $this->periodo->all();

		return View::make('admin.periodos.index', compact('periodos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.periodos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Periodo::$rules);

		if ($validation->passes())
		{
			$this->periodo->create($input);

			return Redirect::route('admin.periodos.index');
		}

		return Redirect::route('admin.periodos.create')
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
		$periodo = $this->periodo->findOrFail($id);

		return View::make('admin.periodos.show', compact('periodo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$periodo = $this->periodo->find($id);

		if (is_null($periodo))
		{
			return Redirect::route('admin.periodos.index');
		}

		return View::make('admin.periodos.edit', compact('periodo'));
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
		$validation = Validator::make($input, Periodo::$rules);

		if ($validation->passes())
		{
			$periodo = $this->periodo->find($id);
			$periodo->update($input);

			return Redirect::route('admin.periodos.show', $id);
		}

		return Redirect::route('admin.periodos.edit', $id)
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
		$this->periodo->find($id)->delete();

		return Redirect::route('admin.periodos.index');
	}

}
