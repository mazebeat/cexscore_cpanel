<?php

class CsUsuariosController extends BaseController
{

    /**
     * Usuario Repository
     *
     * @var Usuario
     */
    protected $csusuario;

    public function __construct(CsUsuario $csusuario)
    {
        $this->csusuario = $csusuario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $idCliente = \Auth::user()->cliente->id_cliente;
        $csusuario = $this->csusuario->where('id_cliente', $idCliente)->get();

        return View::make('admin.usuarios.index', compact('csusuario'));
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
            $this->csusuario->create($input);

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
        $usuario = $this->csusuario->findOrFail($id);

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
        $csusuario = $this->csusuario->find($id);

        if (is_null($csusuario)) {
            return Redirect::route('admin.usuarios.index');
        }

        return View::make('admin.usuarios.edit', compact('csusuario'));
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
            $csusuario = $this->csusuario->find($id);
            $csusuario->update($input);

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
        $this->csusuario->find($id)->delete();

        return Redirect::route('admin.usuarios.index');
    }

    public function resetPassword($id)
    {
        $client = $this->csusuario->find($id);
        if (!is_null($client)) {
            //            $idCliente = \Auth::user()->cliente->id_cliente;
            //            $usuarios  = Usuario::where('id_cliente', $idCliente)->get();

            if ($client->resetPassword()) {
                Session::flash('message', 'Reset Password, OK!');

                return Redirect::route('admin.usuarios.index');
            }
        }

        Session::flash('message', 'Reset Password, Wrong!');

        return Redirect::route('admin.usuarios.index');
    }
}
