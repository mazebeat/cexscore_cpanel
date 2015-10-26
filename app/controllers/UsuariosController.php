<?php

class UsuariosController extends BaseController
{

    /**
     * Usuario Repository
     *
     * @var Usuario
     */
    protected $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $idCliente = \Auth::user()->cliente->id_cliente;
        $usuarios  = $this->usuario->where('id_cliente', $idCliente)->get();

        return View::make('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all();
        $validation = Validator::make($input, Usuario::$rules);
        $idCliente  = \Auth::user()->cliente->id_cliente;
        $idEncuesta = \Auth::user()->cliente->encuesta->id_encuesta;
        array_set($input, 'id_cliente', $idCliente);
        array_set($input, 'id_encuesta', $idEncuesta);

        if ($validation->passes()) {
            $this->usuario->create($input);

            return Redirect::route('admin.usuarios.index');
        }

        return Redirect::route('admin.usuarios.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $usuario = $this->usuario->findOrFail($id);

        return View::make('admin.usuarios.show', compact('usuario'));
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
        $usuario = $this->usuario->find($id);

        if (is_null($usuario)) {
            return Redirect::route('admin.usuarios.index');
        }

        return View::make('admin.usuarios.edit', compact('usuario'));
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
        $validation = Validator::make($input, Usuario::$rules);

        if ($validation->passes()) {
            $usuario = $this->usuario->find($id);
            $usuario->update($input);

            return Redirect::route('admin.usuarios.show', $id);
        }

        return Redirect::route('admin.usuarios.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $this->usuario->find($id)->delete();

        return Redirect::route('admin.usuarios.index');
    }

}
