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
        try {
            $input = Input::all();
            array_set($input, 'id_estado', true);

            $validation = Validator::make($input, Sector::$rules);
            if (!$validation->passes()) {
                return Redirect::route('admin.sectors.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
            }

            array_set($input, 'titulo', Input::get('descripcion_sector'));
            $validation = Validator::make($input, Encuesta::$rules);
            if (!$validation->passes()) {
                return Redirect::route('admin.sectors.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
            }

            $this->sector = $this->sector->create($input);

            $data   = array(
                'titulo'      => Input::get('descripcion_sector'),
                'description' => Input::get('description'),
            );
            $survey = self::saveSurvey($data);
            if ($survey != null) {
                \PreguntaCabecera::generateQuestions($survey, Input::only(['preguntaCabecera']));
                $this->sector->encuestas()->save($survey);
            } else {
                Log::error('Error al guardar Encuesta, Sector ["' . $this->sector->id_sector . '"]');

                return Redirect::back();
            }

            return Redirect::route('admin.sectors.index');

        } catch (Exception $e) {
            self::throwError($e);
        }
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
        $survey   = $sector->encuestas()->first();

        if (is_null($sector)) {
            return Redirect::route('admin.sectors.index');
        }

        return View::make('admin.sectors.edit', compact('sector'))
                   ->with('catgs', $catgs)
                   ->with('survey', $survey);
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
        $input = array_except(Input::all(), '_method');

        array_set($input, 'id_estado', true);
        $validation = Validator::make($input, Sector::$rules);
        if (!$validation->passes()) {
            return Redirect::route('admin.sectors.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
        }

        array_set($input, 'titulo', Input::get('descripcion_sector'));
        $validation = Validator::make($input, Encuesta::$rules);
        if (!$validation->passes()) {
            return Redirect::route('admin.sectors.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
        }

        $sector = $this->sector->find($id);
        $sector->update($input);

        self::modifySurvey2(Input::except(['_token', 'descripcion_sector', '_method']), $sector->encuestas()->first());
        $survey = $sector->encuestas()->first();
        $survey->description = Input::get('description');
        $survey->save();

        return Redirect::route('admin.sectors.show', $id);
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
        $this->sector = $this->sector->find($id);
        $survey       = $this->sector->encuestas()->first();
        $this->sector->encuestas()->detach();
        $this->sector->delete();
        $survey->preguntas()->delete();
        $survey->delete();

        return Redirect::route('admin.sectors.index');
    }

}
