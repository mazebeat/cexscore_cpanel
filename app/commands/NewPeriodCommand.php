<?php

use Illuminate\Console\Command;

class NewPeriodCommand extends Command
{
    protected $name        = 'cpanel:newperiod';
    protected $description = 'Inserta periodo actual en la tabla CS_Periodo.';
    protected $accounts;
    protected $mes;
    protected $anio;
    protected $periodo;
    protected $meta;

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $this->init();
        $this->insert();
    }

    private function init()
    {
        $this->line("Init Process.");
        $this->accounts = Cliente::all();
        $this->anio     = Carbon::now()->year;
        $this->mes      = Carbon::now()->month;
        $this->periodo  = Carbon::createFromDate($this->anio, $this->mes, 1)->format('Y-m');

        $this->progressbar = $this->getHelperSet()->get('progress');
        $this->progressbar->start($this->output, count($this->accounts));
    }

    private function insert()
    {
        try {
            $this->info("Cargando Periodo '{$this->periodo}'");

            foreach ($this->accounts as $key => $value) {
                $this->info("'{$value->nombre_cliente}'");
                Log::info("Cargando Periodos para '{$value->nombre_cliente}'");

                $id = $value->id_cliente;

                $period     = Periodo::whereIdCliente($id)->orderBy('anio', 'DESC')->orderBy('mes', 'DESC')->first();
                $this->meta = $value->plan->cantidad_encuestas_plan;

                if (is_null($this->meta)) {
                    if (!is_null($period)) {
                        $this->meta = $period->meta;
                    } else {
                        $this->meta = 50;
                    }
                }

                if (!is_null($period)) {
                    if ((int)$period->mes < $this->mes && (int)$period->anio <= $this->anio) {
                        $period             = new Periodo();
                        $period->periodo    = $this->periodo;
                        $period->anio       = $this->anio;
                        $period->mes        = $this->mes;
                        $period->meta       = $this->meta;
                        $period->id_cliente = $id;

                        if ($period->save()) {
                            $this->info("Periodo creado '{$this->periodo}'.");

                            Log::info("Periodo creado '{$this->periodo}'.");
                            $this->progressbar->advance();
                        } else {
                            $this->error("Periodo no creado '{$this->periodo}'.");
                            Log::error("Periodo no creado '{$this->periodo}'.");
                        }
                    } else {
                        $this->line("Periodo '{$this->periodo}' ya ingresado.");
                        Log::info("Periodo '{$this->periodo}' ya ingresado.");
                    }
                } else {
                    $this->comment("No se encontraron periodos.");
                    Log::info("No se encontraron periodos.");
                    $this->comment("Insertando periodo '{$this->periodo}'.");
                    Log::info("Insertando periodo '{$this->periodo}'.");

                    $period             = new Periodo();
                    $period->periodo    = $this->periodo;
                    $period->anio       = $this->anio;
                    $period->mes        = $this->mes;
                    $period->meta       = $this->meta;
                    $period->id_cliente = $id;

                    if ($period->save()) {
                        $this->info("Periodo creado '{$this->periodo}'.");
                        Log::info("Periodo creado '{$this->periodo}'.");
                        $this->progressbar->advance();
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            Log::error($e->getMessage());
        }

        $this->progressbar->finish();
        $this->info('Done');
    }

    protected function getArguments()
    {
        return array();
    }

    protected function getOptions()
    {
        return array();
    }
}