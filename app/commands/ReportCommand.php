<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReportCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sendreport';

    protected $accounts;
    protected $admin;
    protected $pathFile;
    protected $date;
    protected $attachFile;
    protected $html;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia mail reporte ejecutivo a responsables de cuenta.';

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
        $this->send();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            //			array('example', InputArgument::REQUIRED, 'An example argument.'),
            //			array( 'name', 'mode', 'description', 'defaultValue' )
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            //			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
            //			array('name', 'shortcut', 'mode', 'description', 'defaultValue')
        );
    }

    private function init()
    {
        $this->line("Init Process.");
        $this->accounts = Cliente::all();

        $this->progressbar = $this->getHelperSet()->get('progress');
        $this->progressbar->start($this->output, count($this->accounts));
    }

    private function send()
    {
        try {

            // FIND ACCOUNT
            foreach ($this->accounts as $key => $value) {
                if ($value) {
                    $this->info("Cuenta encontrada '{$value->nombre_cliente}'");
                    $this->comment("Buscando responsable");
                    $this->admin = CsUsuario::whereIdCliente($value->id_cliente)->where('responsable', true)->first();

                    if (!is_null($this->admin)) {
                        $this->pathFile = public_path('temp/' . \Str::camel($value->nombre_cliente) . '.pdf');

                        // RENDER VIEW
                        $this->info("Generando reporte");
                        $start     = Carbon::now()->startOfWeek();
                        $end       = Carbon::now()->endOfWeek();
                        $dateRange = "Semana del {$start->day} al {$end->day} de {$end->format('M')} {$end->year}";

                        $this->html = View::make('pdf.reporte')->with('account', $value)->with('dateRange', $dateRange)->render();

                        // SAVE PDF
                        $pdf = \App::make('snappy.pdf.wrapper');
                        $pdf->loadHTML($this->html)->setPaper('letter');

                        if ($pdf->save($this->pathFile)) {
                            $this->info("Generando email");
                            $data = array(
                                'nombre_usuario' => $this->admin->nombre,
                            );
                            $mail = array(
                                'email'   => $this->admin->email,
                                'name'    => $this->admin->nombre,
                                'subject' => 'Actualización Semanal Panel de Experiencia del Cliente',
                                'attach'  => $this->pathFile,
                            );

                            $this->line("Enviando email a '{$this->admin->email}'");
                            \Mail::queue('emails.reporte', $data, function ($message) use ($mail) {
                                $message->from('ayuda@customertrigger.com', 'CExScore');
                                $message->to($mail['email'], $mail['name'])->subject($mail['subject']);
                                $message->attach($mail['attach']);
                            });
                        }
                    } else {
                        $this->line("No se encontraron responsables para '{$value->nombre_cliente}'");
                    }
                }

                $this->progressbar->advance();
            }

            File::cleanDirectory(public_path('temp'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            Log::error($e->getMessage());
        }

        $this->progressbar->finish();
        $this->info('Done');
    }
}
