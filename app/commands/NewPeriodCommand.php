<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NewPeriodCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'newperiod';
    protected $accounts;
    protected $mes;
    protected $anio;
    protected $periodo;
    protected $meta;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta periodo actual en la tabla CS_Periodo.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->init();
        $this->insert();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(//            array('example', InputArgument::REQUIRED, 'An example argument.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(//            array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
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
}
