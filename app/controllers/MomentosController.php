<?php

class MomentosController extends \ApiController {

	/**
	 * Momento Repository
	 *
	 * @var Momento
	 */
	protected $momento;

	public function __construct(Momento $momento)
	{
		$this->momento = $momento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$momentos = $this->momento->all();

		return View::make('admin.momentos.index', compact('momentos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.momentos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Momento::$rules);

		if ($validation->passes())
		{
			$this->momento->create($input);

			return Redirect::route('admin.momentos.index');
		}

		return Redirect::route('admin.momentos.create')
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
		$momento = $this->momento->findOrFail($id);

		return View::make('admin.momentos.show', compact('momento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$momento = $this->momento->find($id);

		if (is_null($momento))
		{
			return Redirect::route('admin.momentos.index');
		}

		return View::make('admin.momentos.edit', compact('momento'));
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
		$validation = Validator::make($input, Momento::$rules);

		if ($validation->passes())
		{
			$momento = $this->momento->find($id);
			$momento->update($input);

			return Redirect::route('admin.momentos.show', $id);
		}

		return Redirect::route('admin.momentos.edit', $id)
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
		$this->momento->find($id)->delete();

		return Redirect::route('admin.momentos.index');
	}

}
