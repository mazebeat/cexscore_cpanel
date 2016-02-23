<?php

class CanalsController extends \ApiController
{

    /**
     * Canal Repository
     *
     * @var Canal
     */
    protected $canal;

    public function __construct(Canal $canal)
    {
        $this->canal = $canal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $canals = $this->canal->paginate(15);

        return View::make('admin.canals.index', compact('canals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.canals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all();
        $validation = Validator::make($input, Canal::$rules);
        $codigo     = array_get($input, 'codigo_canal');

        if (Str::length($codigo) > 2) {
            array_set($input, 'codigo_canal', Str::limit($codigo, 2, ''));
        }

        if ($validation->passes()) {
            $this->canal->create($input);

            return Redirect::route('admin.canals.index');
        }

        return Redirect::route('admin.canals.create')
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
        $canal = $this->canal->findOrFail($id);

        return View::make('admin.canals.show', compact('canal'));
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
        $canal = $this->canal->find($id);

        if (is_null($canal)) {
            return Redirect::route('admin.canals.index');
        }

        return View::make('admin.canals.edit', compact('canal'));
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
        $validation = Validator::make($input, Canal::$rules);

        if ($validation->passes()) {
            $codigo = array_get($input, 'codigo_canal');

            if (Str::length($codigo) > 2) {
                array_set($input, 'codigo_canal', Str::limit($codigo, 2, ''));
            }

            $canal = $this->canal->find($id);
            $canal->update($input);

            return Redirect::route('admin.canals.show', $id);
        }

        return Redirect::route('admin.canals.edit', $id)
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
        $this->canal = $this->canal->find($id);

        if ($this->canal->urls()->count()) {
            return Redirect::route('admin.canals.index')->withErrors(['No se puede eliminar canal, mantiene momentos asociados']);
        }

        $this->canal->delete();

        return Redirect::route('admin.canals.index');
    }

}
