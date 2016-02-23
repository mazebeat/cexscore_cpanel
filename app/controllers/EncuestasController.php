<?php

class EncuestasController extends \ApiController
{

    /**
     * Encuesta Repository
     *
     * @var Encuesta
     */
    protected $encuestum;

    public function __construct(Encuesta $encuestum)
    {
        $this->encuestum = $encuestum;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $encuesta = $this->encuestum->paginate(15);

        return View::make('admin.encuesta.index', compact('encuesta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.encuesta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all();
        $validation = Validator::make($input, Encuesta::$rules);

        if ($validation->passes()) {
            $survey = $this->encuestum->create($input);

            // Generate default questions
            \PreguntaCabecera::generateDefaultQuestions($survey);

            return Redirect::route('admin.encuesta.index');
        }

        return Redirect::route('admin.encuesta.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $encuestum = $this->encuestum->findOrFail($id);

        return View::make('admin.encuesta.show', compact('encuestum'));
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
        $encuestum = $this->encuestum->find($id);
        $isMy      = false;
        $tipouser  = Auth::user()->id_tipo_usuario;

        //        if ($tipouser <= Config::get('tipousuario.admin') || ($tipouser == 3 && \Auth::user()->cliente->encuesta->id_encuesta == $id)) {
        if ($tipouser <= Config::get('tipousuario.admin')) {
            $isMy = true;
        }

        if (is_null($encuestum)) {
            return \Redirect::route('admin.encuesta.index');
        }

        return View::make('admin.survey.loadSurvey')->with('survey', $encuestum)->with('isMy', $isMy)->with('id', $encuestum->id_encuesta)->with('description', $encuestum->description);
        //        return View::make('admin.encuesta.edit', compact('encuestum'));
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
        $validation = Validator::make($input, Encuesta::$rules);


        if ($validation->passes()) {
            $encuestum = $this->encuestum->find($id);
            $encuestum->update($input);

            return Redirect::route('admin.encuesta.show', $id);
        }

        return Redirect::route('admin.encuesta.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $qs = $this->encuestum->find($id)->preguntas;
        foreach ($qs as $k => $v) {
            $v->delete();
        }
        $this->encuestum->find($id)->delete();

        return Redirect::route('admin.encuesta.index');
    }
}
