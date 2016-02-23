<?php

class CiudadsController extends \ApiController
{

    /**
     * Ciudad Repository
     *
     * @var Ciudad
     */
    protected $ciudad;

    public function __construct(Ciudad $ciudad)
    {
        $this->ciudad = $ciudad;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $ciudads = $this->ciudad->orderBy('descripcion_ciudad')->paginate(15);
        $regions = Region::lists('descripcion_region', 'id_region');

        return View::make('admin.ciudads.index', compact('ciudads'))->withRegiones($regions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $regions = Region::lists('descripcion_region', 'id_region');

        return View::make('admin.ciudads.create')->withRegiones($regions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all();
        $validation = Validator::make($input, Ciudad::$rules);

        if ($validation->passes()) {
            $this->ciudad->create($input);

            return Redirect::route('admin.ciudads.index');
        }

        return Redirect::route('admin.ciudads.create')
                       ->withInput()
                       ->withErrors($validation)
                       ->with('message', 'There were validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ciudad  = $this->ciudad->findOrFail($id);
        $regions = Region::lists('descripcion_region', 'id_region');

        return View::make('admin.ciudads.show', compact('ciudad'))->withRegiones($regions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ciudad = $this->ciudad->find($id);

        if (is_null($ciudad)) {
            return Redirect::route('admin.ciudads.index');
        }

        $regions = Region::lists('descripcion_region', 'id_region');

        return View::make('admin.ciudads.edit', compact('ciudad'))->withRegiones($regions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $input      = array_except(Input::all(), '_method');
        $validation = Validator::make($input, Ciudad::$rules);

        if ($validation->passes()) {
            $ciudad = $this->ciudad->find($id);
            $ciudad->update($input);

            return Redirect::route('admin.ciudads.show', $id);
        }

        return Redirect::route('admin.ciudads.edit', $id)
                       ->withInput()
                       ->withErrors($validation)
                       ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->ciudad->find($id)->delete();

        return Redirect::route('admin.ciudads.index');
    }

}
