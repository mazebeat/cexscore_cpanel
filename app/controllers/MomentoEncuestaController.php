<?php

class MomentoEncuestaController extends BaseController
{

    /**
     * MomentoEncuesta Repository
     *
     * @var MomentoEncuesta
     */
    protected $momentoencuesta;

    public function __construct(MomentoEncuesta $momentoencuesta)
    {
        $this->momentoencuesta = $momentoencuesta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $idEncuesta      = Auth::user()->cliente->encuesta->id_encuesta;
        $momentoencuesta = $this->momentoencuesta->where('id_encuesta', $idEncuesta)->get();

        return View::make('admin.momentoencuesta.index', compact('momentoencuesta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $moments = Momento::lists('descripcion_momento', 'id_momento');

        return View::make('admin.momentoencuesta.create')->with('moments', $moments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all();
        $validation = Validator::make($input, MomentoEncuesta::$rules);

        if ($validation->passes()) {
            $this->momentoencuesta->create($input);

            return Redirect::route('admin.momentoencuesta.index');
        }

        return Redirect::route('admin.momentoencuesta.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $momentoencuestum = $this->momentoencuestum->findOrFail($id);

        return View::make('admin.momentoencuesta.show', compact('momentoencuestum'));
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
        $momentoencuesta = $this->momentoencuesta->find($id);

        if (is_null($momentoencuesta)) {
            return Redirect::route('admin.momentoencuesta.index');
        }

        $moments = Momento::lists('descripcion_momento', 'id_momento');

        return View::make('admin.momentoencuesta.edit', compact('momentoencuesta'))->with('moments', $moments);
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
        $validation = Validator::make($input, MomentoEncuesta::$rules);

        if ($validation->passes()) {
            $momentoencuesta = $this->momentoencuesta->find($id);
            $momentoencuesta->update($input);

            return Redirect::route('admin.momentoencuesta.show', $id);
        }

        return Redirect::route('admin.momentoencuesta.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $this->momentoencuesta->find($id)->delete();

        return Redirect::route('admin.momentoencuesta.index');
    }

}
