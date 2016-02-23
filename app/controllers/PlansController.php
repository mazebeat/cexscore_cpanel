<?php

class PlansController extends BaseController
{

    /**
     * Plan Repository
     *
     * @var Plan
     */
    protected $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $plans = $this->plan->paginate(15);


        return View::make('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $input = $this->cleanCheckboxInputs('optin_plan', $input);
        $input = $this->cleanCheckboxInputs('descarga_datos_plan', $input);

        $validation = Validator::make($input, Plan::$rules);

        if ($validation->passes()) {
            $this->plan->create($input);

            return Redirect::route('admin.plans.index');
        }

        return Redirect::route('admin.plans.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $plan = $this->plan->findOrFail($id);

        return View::make('admin.plans.show', compact('plan'));
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
        $plan = $this->plan->find($id);

        if (is_null($plan)) {
            return Redirect::route('admin.plans.index');
        }

        return View::make('admin.plans.edit', compact('plan'));
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
        $input = Input::except('_method');
        $input = $this->cleanCheckboxInputs('optin_plan', $input);
        $input = $this->cleanCheckboxInputs('descarga_datos_plan', $input);

        $validation = Validator::make($input, Plan::$rules);

        if ($validation->passes()) {
            $plan = $this->plan->find($id);
            $plan->update($input);

            return Redirect::route('admin.plans.show', $id);
        }

        return Redirect::route('admin.plans.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
    }

    /**
     * @param       $name
     * @param array $input
     *
     * @return array
     */
    public function cleanCheckboxInputs($name, $input = array())
    {
        if (array_key_exists($name, $input)) {
            $a = array_get($input, $name, null);
            if (!is_null($a)) {
                \Str::lower($a) == 'on' ? array_set($input, $name, true) : array_set($input, $name, false);
            }
        } else {
            $input = array_add($input, $name, false);
        }

        return $input;
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
        $this->plan = $this->plan->find($id);
        if ($this->plan->clientes()->count()) {
            return Redirect::route('admin.plans.index')->withErrors(['No se puede eliminar sector, contiene clientes asociadas']);
        }
        $this->plan->delete();

        return Redirect::route('admin.plans.index');
    }

}
