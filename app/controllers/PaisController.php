<?php

class PaisController extends \ApiController
{

    /**
     * Pais Repository
     *
     * @var Pais
     */
    protected $pais;

    public function __construct(Pais $pais)
    {
        $this->pais = $pais;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pais = $this->pais->orderBy('descripcion_pais')->paginate(15);

        return View::make('admin.pais.index', compact('pais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.pais.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all();
        $validation = Validator::make($input, Pais::$rules);

        if ($validation->passes()) {
            $this->pais->create($input);

            return Redirect::route('admin.pais.index');
        }

        return Redirect::route('admin.pais.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $pais = $this->pais->findOrFail($id);

        return View::make('admin.pais.show', compact('pais'));
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
        $pais = $this->pais->find($id);

        if (is_null($pais)) {
            return Redirect::route('admin.pais.index');
        }

        return View::make('admin.pais.edit', compact('pais'));
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
        $validation = Validator::make($input, Pais::$rules);

        if ($validation->passes()) {
            $pais = $this->pais->find($id);
            $pais->update($input);

            return Redirect::route('admin.pais.show', $id);
        }

        return Redirect::route('admin.pais.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $this->pais->find($id)->delete();

        return Redirect::route('admin.pais.index');
    }

}
