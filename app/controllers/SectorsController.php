<?php

use Illuminate\Support\Facades\Auth;

class SectorsController extends \ApiController
{

    /**
     * Sector Repository
     *
     * @var Sector
     */
    protected $sector;

    public function __construct(Sector $sector)
    {
        $this->sector = $sector;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sectors = $this->sector->all();

        return View::make('admin.sectors.index', compact('sectors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $catgs = Categoria::select('descripcion_categoria')->orderBy('id_categoria')->lists('descripcion_categoria');

        return View::make('admin.sectors.create')->with('catgs', $catgs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all();
        $validation = Validator::make($input, Sector::$rules);

        if ($validation->passes()) {
            $this->sector->create($input);

            $survey = self::saveSurvey(Input::only(['titulo']));
            if ($survey != null) {
                \PreguntaCabecera::generateDefaultQuestions($survey, Input::only(['preguntaCabecera']));
            }

            return Redirect::route('admin.sectors.index');
        }

        return Redirect::route('admin.sectors.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $sector = $this->sector->findOrFail($id);

        return View::make('admin.sectors.show', compact('sector'));
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

        $sector   = $this->sector->find($id);
        $catgs    = Categoria::select('descripcion_categoria')->orderBy('id_categoria')->lists('descripcion_categoria');
        $survey   = EncuestaSector::where('id_sector', $id)->first(['id_encuesta'])->encuesta;
        $isMy     = false;
        $tipouser = Auth::user()->id_tipo_usuario;

        //        $x = Auth::user()->cliente->encuesta->id_encuesta;
        //        if ($survey->id_encuesta == $x || Auth::user()->id_tipo_usuario <= Config::get('tipousuario.admin')) {
        if ($tipouser <= Config::get('tipousuario.admin')) {
            $isMy = true;
        }

        if (is_null($sector)) {
            return Redirect::route('admin.sectors.index');
        }

        return View::make('admin.sectors.edit', compact('sector'))->with('catgs', $catgs)->with('survey', $survey)->with('isMy', $isMy);
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
        $validation = Validator::make($input, Sector::$rules);

        if ($validation->passes()) {
            $sector = $this->sector->find($id);
            $sector->update($input);

            return Redirect::route('admin.sectors.show', $id);
        }

        return Redirect::route('admin.sectors.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $this->sector->find($id)->delete();

        return Redirect::route('admin.sectors.index');
    }

}
