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
        $usuarios = Usuario::all();
        $cuentas = Cliente::lists('nombre_cliente', 'id_cliente');

        return View::make('admin.usuarios.index', compact('usuarios'))->with('cuentas', $cuentas);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cuentas = Cliente::lists('nombre_cliente', 'id_cliente');
        return View::make('admin.usuarios.create')->with('cuentas', $cuentas);;
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
        if (array_get($input, 'fecha_nacimiento') == "") {
            array_set($input, 'fecha_nacimiento', null);
        } else {
            $born = Carbon::parse(array_get($input, 'fecha_nacimiento'));
            $age  = $born->age;

            array_set($input, 'fecha_nacimiento', $born);
            array_set($input, 'edad_usuario', $age);
        }

        $cliente = \Auth::user()->cliente;
        array_set($input, 'id_cliente', $cliente->id_cliente);
        array_set($input, 'id_encuesta', $cliente->encuesta->id_encuesta);

        $validation = Validator::make($input, Usuario::$rules);

        if ($validation->passes()) {
            $this->usuario->create($input);

            return Redirect::route('admin.usuarios.index');
        }

        return Redirect::route('admin.usuarios.create')->withInput()->withErrors($validation)->with('message',
            'There were validation errors.');
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
        $cuentas = Cliente::lists('nombre_cliente', 'id_cliente');

        return View::make('admin.usuarios.show', compact('usuario'))->with('cuentas', $cuentas);;
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

        $cuentas = Cliente::lists('nombre_cliente', 'id_cliente');

        return View::make('admin.usuarios.edit', compact('usuario'))->with('cuentas', $cuentas);;
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
        $rules = array(
            'nombre_usuario'       => 'required',
            'password'             => 'required',
            'edad_usuario'         => '',
            'fecha_nacimiento'     => '',
            'genero_usuario'       => '',
            'correo_usuario'       => 'required',
            'rut_usuario'          => 'required',
            'desea_correo_usuario' => '',
            'id_tipo_usuario'      => 'required',
            'id_cliente'           => 'required',
            'id_encuesta'          => 'required',
        );

        $input      = array_except(Input::all(), '_method');
        $validation = Validator::make($input, $rules);

        if ($validation->passes()) {
            $usuario = $this->usuario->find($id);
            $usuario->update($input);

            return Redirect::route('admin.usuarios.show', $id);
        }

        return Redirect::route('admin.usuarios.edit', $id)->withInput()->withErrors($validation)->with('message',
            'There were validation errors.');
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
        $validator = Validator::make(Input::all(), Usuario::$rulesChangePasword, Usuario::$messagesChangePassword);

        if ($validator->fails()) {
            if (Request::ajax()) {
                return Response::json(array('message' => $validator->messages(), 'pass' => false));
            }

            return Redirect::back()->withErrors($validator);
        }

        $usuario = $this->usuario->find($id);

        if (!is_null($usuario)) {
            $usuario->password = Hash::make(Input::get('password'));

            if ($usuario->save()) {
                if (Request::ajax()) {
                    return Response::json(array('message' => array('Change Password, OK!'), 'pass' => true));
                }

                Session::flash('message', 'Change Password, OK!');

                return Redirect::route('admin.usuarios.index');
            }
        }

        if (Request::ajax()) {
            return Response::json(array('message' => array('Change Password, Wrong!'), 'pass' => false));
        }

        Session::flash('message', 'Change Password, Wrong!');

        return Redirect::route('admin.usuarios.index');
    }
}