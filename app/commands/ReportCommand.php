<?php

use Illuminate\Console\Command;

class ReportCommand extends Command
{
    protected $name        = 'cpanel:sendreport';
    protected $description = 'Envia mail reporte ejecutivo a responsables de cuenta.';
    protected $accounts;
    protected $admin;
    protected $file;
    protected $pathFile;
    protected $date;
    protected $attachFile;
    protected $html;

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $this->init();
        $this->send();
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
            foreach ($this->accounts as $key => $value) {
                if ($value) {
                    $this->info("Cuenta encontrada '{$value->nombre_cliente}'");
                    $this->comment("Buscando responsable");
                    $this->admin = CsUsuario::whereIdCliente($value->id_cliente)->where('responsable', true)->first();

                    if (!is_null($this->admin)) {
                        $start = Carbon::now()->startOfWeek();
                        $end   = Carbon::now()->endOfWeek();

                        $this->file     = \Str::title(\Str::camel($value->nombre_cliente)) . '.pdf'; // \Str::camel($value->nombre_cliente) . "_{$start->year}{$start->month}{$start->day}" . '.pdf';
                        $this->pathFile = public_path('temp' . DIRECTORY_SEPARATOR . $value->id_cliente . DIRECTORY_SEPARATOR);
                        $realfile       = $this->pathFile . $this->file;

                        $this->validateFileCreatedAt($realfile);

                        $this->info("Generando reporte");
                        $dateRange = "Semana del {$start->day} al {$end->day} de {$end->format('M')} {$end->year}";

                        $this->html = View::make('pdf.reporte')->with('account', $value)->with('dateRange', $dateRange)->render();
                        $semanal    = View::make('pdf.semanal')->with('account', $value)->with('dateRange', $dateRange)->render();

                        $pdf = \App::make('snappy.pdf.wrapper');
                        $pdf->loadHTML($this->html)->setPaper('letter');

                        if ($pdf->save($realfile)) {
                            $this->info("Generando email");
                            $data = array(
                                'nombre_usuario' => $this->admin->nombre,
                                'html'           => $semanal,
                            );
                            $mail = array(
                                'email'   => $this->admin->email,
                                'name'    => $this->admin->nombre,
                                'subject' => 'Actualización Semanal Panel de Experiencia del Cliente',
                                'attach'  => $realfile,
                            );

                            $this->line("Enviando email a '{$this->admin->email}'");
                            \Mail::queue('emails.reporte', $data, function ($message) use ($mail) {
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
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            Log::error($e->getMessage());
        }

        $this->progressbar->finish();
        $this->info('Done');
    }

    public function validateFileCreatedAt($file)
    {
        if (File::exists($file)) {
            File::delete($file);
        }
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
