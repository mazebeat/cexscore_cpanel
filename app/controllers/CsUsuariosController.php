<?php

class CsUsuariosController extends \ApiController
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
        $idCliente  = \Auth::user()->cliente->id_cliente;
        $csusuarios = $this->csusuario->where('id_cliente', $idCliente)->get();

        return View::make('admin.csusuarios.index', compact('csusuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.csusuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input     = Input::all();
        $username  = self::randomCsUsername($input);
        $input     = array_add($input, 'nombre', Input::get('nombre_usuario') . ' ' . Input::get('apellido_usuario'));
        $input     = array_add($input, 'usuario', $username);
        $input     = array_add($input, 'responsable', 0);
        $input     = array_add($input, 'pwdusuario', 'e10adc3949ba59abbe56e057f20f883e');
        $idCliente = \Auth::user()->cliente->id_cliente;
        array_set($input, 'id_cliente', $idCliente);
        array_set($input, 'id_perfil', 3);

        $validation = Validator::make($input, CsUsuario::$rules);

        if ($validation->passes()) {
            $this->csusuario->create($input);

            return Redirect::route('admin.csusuarios.index');
        }

        return Redirect::route('admin.csusuarios.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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

        return View::make('admin.csusuarios.show', compact('usuario'));
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
            return Redirect::route('admin.csusuarios.index');
        }

        return View::make('admin.csusuarios.edit', compact('csusuario'));
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
        $validation = Validator::make($input, array(
            'id_perfil'        => '',
            'usuario'          => 'required',
            'pwdusuario'       => '',
            'nombre'           => '',
            'rut'              => 'rut',
            'fecha_nacimiento' => '',
            'edad'             => '',
            'genero'           => '',
            'linkedlin'        => '',
            'email'            => 'email',
            'activo'           => '',
            'fecha_registro'   => '',
            'id_cliente'       => 'required',
        ));

        if ($validation->passes()) {
            $csusuario = $this->csusuario->find($id);
            $csusuario->update($input);

            return Redirect::route('admin.csusuarios.show', $id);
        }

        return Redirect::route('admin.csusuarios.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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

        return Redirect::route('admin.csusuarios.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function resetPassword($id)
    {
        $csusuario = $this->csusuario->find($id);
        if (!is_null($csusuario)) {
            if ($csusuario->resetPassword()) {
                Session::flash('message', 'Reset Password, OK!');

                return Redirect::route('admin.csusuarios.index');
            }
        }

        Session::flash('message', 'Reset Password, Wrong!');

        return Redirect::route('admin.csusuarios.index');
    }

    /**
     *
     */
    public function showChangePassword()
    {

    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function changePassword($id)
    {
        if (Input::get('pwdusuario') != '' || !is_null(Input::get('pwdusuario'))) {
            Session::flash('message', 'Reset Password, Wrong!');

            return Redirect::route('admin.csusuarios.index');
        }

        $csusuario = $this->csusuario->find($id);
        if (!is_null($csusuario)) {
            $csusuario->pwdusuario = md5(Input::get('pwdusuario'));

            if ($csusuario->save()) {
                return Redirect::route('admin.csusuarios.index');
            }
        }

        Session::flash('message', 'Reset Password, Wrong!');

        return Redirect::route('admin.csusuarios.index');
    }
}
