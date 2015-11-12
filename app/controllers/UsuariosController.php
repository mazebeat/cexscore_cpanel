<?php

class UsuariosController extends \ApiController
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
        $input    = Input::all();
        $username = self::randomUsername($input);
        $input    = array_add($input, 'username', $username);
        $input    = array_add($input, 'responsable', 0);
        $input    = array_add($input, 'password', Hash::make('123456'));
        $cliente  = \Auth::user()->cliente;
        array_set($input, 'id_cliente', $cliente->id_cliente);
        array_set($input, 'id_encuesta', $cliente->encuesta->id_encuesta);

        $validation = Validator::make($input, Usuario::$rules);

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

    /**
     * @param $id
     *
     * @return mixed
     */
    public function resetPassword($id)
    {
        $usuario = $this->usuario->find($id);
        if (!is_null($usuario)) {
            if ($usuario->resetPassword()) {
                Session::flash('message', 'Reset Password, OK!');

                return Redirect::route('admin.usuarios.index');
            }
        }

        Session::flash('message', 'Reset Password, Wrong!');

        return Redirect::route('admin.usuarios.index');
    }

    /**
     *
     */
    public function showChangePassword() {

    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function changePassword($id)
    {
        if (Input::get('password') != '' || !is_null(Input::get('password'))) {
            Session::flash('message', 'Reset Password, Wrong!');

            return Redirect::route('admin.csusuarios.index');
        }

        $usuario = $this->usuario->find($id);
        if (!is_null($usuario)) {
            $usuario->password = Hash::make(Input::get('password'));

            if ($usuario->save()) {
                return Redirect::route('admin.usuarios.index');
            }
        }

        Session::flash('message', 'Reset Password, Wrong!');

        return Redirect::route('admin.usuarios.index');
    }
}
