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
        $csusuarios = $this->csusuario->paginate(15);
        $cuentas    = Cliente::lists('nombre_cliente', 'id_cliente');

        return View::make('admin.csusuarios.index', compact('csusuarios'))->with('cuentas', $cuentas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cuentas = Cliente::lists('nombre_cliente', 'id_cliente');

        return View::make('admin.csusuarios.create')->with('cuentas', $cuentas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input    = Input::all();
        $username = self::randomCsUsername($input);
        $input    = array_add($input, 'nombre', Input::get('nombre_usuario') . ' ' . Input::get('apellido_usuario'));
        $input    = array_add($input, 'usuario', $username);
        $input    = array_add($input, 'responsable', 0);
        $input    = array_add($input, 'pwdusuario', md5('123456')); // 'e10adc3949ba59abbe56e057f20f883e'

        if (array_get($input, 'fecha_nacimiento') == "") {
            array_set($input, 'fecha_nacimiento', null);
        } else {
            $born = Carbon::parse(array_get($input, 'fecha_nacimiento'));
            $age  = $born->age;

            array_set($input, 'fecha_nacimiento', $born);
            array_set($input, 'edad', $age);
        }


        $cliente = \Cliente::find(Input::has('id_cliente') ? Input::get('id_cliente') : null);
        if (isset($cliente)) {
            array_set($input, 'id_encuesta', $cliente->encuesta->id_encuesta);
        }

        $validation = Validator::make($input, CsUsuario::$rules);

        if ($validation->passes()) {
            $user = $this->csusuario->create($input);

            self::sendEmailNewUser($user);

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
        $cuentas = Cliente::lists('nombre_cliente', 'id_cliente');

        return View::make('admin.csusuarios.show', compact('usuario'))->with('cuentas', $cuentas);
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

        $cuentas = Cliente::lists('nombre_cliente', 'id_cliente');

        return View::make('admin.csusuarios.edit', compact('csusuario'))->with('cuentas', $cuentas);
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
            'usuario'          => '',
            'pwdusuario'       => '',
            'nombre'           => '',
            'rut'              => 'rut',
            'fecha_nacimiento' => '',
            'edad'             => '',
            'genero'           => '',
            'linkedlin'        => 'url',
            'email'            => 'required|email',
            'activo'           => '',
            'fecha_registro'   => '',
            'id_cliente'       => 'required',
        ), array(
            'id_cliente.required'       => 'Seleccione una cuenta',
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
        $validator = Validator::make(Input::all(), CsUsuario::$rulesChangePasword, CsUsuario::$messagesChangePassword);

        if ($validator->fails()) {
            if (Request::ajax()) {
                return Response::json(array('message' => $validator->messages(), 'pass' => false));
            }

            return Redirect::back()->withErrors($validator);
        }

        $csusuario = $this->csusuario->find($id);
        if (!is_null($csusuario)) {
            $csusuario->pwdusuario = md5(Input::get('pwdusuario'));

            if ($csusuario->save()) {
                if (Request::ajax()) {
                    return Response::json(array('message' => array('Change Password, OK!'), 'pass' => true));
                }

                Session::flash('message', 'Change Password, OK!');

                return Redirect::route('admin.csusuarios.index');
            }
        }

        if (Request::ajax()) {
            return Response::json(array('message' => array('Change Password, Wrong!'), 'pass' => false));
        }

        Session::flash('message', 'Change Password, Wrong!');

        return Redirect::route('admin.csusuarios.index');
    }
}
