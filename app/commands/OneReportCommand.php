<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class OneReportCommand extends Command
{
    protected $name        = 'cpanel:onereport';
    protected $description = 'Genera/Almacena reporte ejecutivo mensual.';
    protected $account;
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
        $this->generate();
    }

    private function init()
    {
        $this->line("Init Process.");

        if (is_null($this->argument('idcliente')) || !is_numeric($this->argument('idcliente'))) {
            $this->error('El argumento "ID Cliente", Debe ser un ID Cliente valido.');
            exit(1);
        }

        $this->account     = Cliente::find($this->argument('idcliente'));
        $this->progressbar = $this->getHelperSet()->get('progress');
        $this->progressbar->start($this->output, count($this->account));
    }

    private function generate()
    {
        try {
            if (!is_null($this->account)) {
                $this->info("Cuenta encontrada '{$this->account->nombre_cliente}'");

                $start = Carbon::now()->subWeek()->startOfWeek();
                $end   = Carbon::now()->subWeek()->endOfWeek();

                $this->file     = \Str::title(\Str::camel($this->account->nombre_cliente)) . '.pdf';
                $this->pathFile = public_path('temp' . DIRECTORY_SEPARATOR . $this->account->id_cliente . DIRECTORY_SEPARATOR);

                if (!\File::exists($this->pathFile)) {
                    // \File::makeDirectory($this->pathFile, 777, true, true);
                    if (!mkdir($this->pathFile, 0777, true)) {
                        Log::error("Fallo al crear las carpetas... ($this->pathFile)");
                        exit;
                    }
                } else {
                    if (!is_writable($this->pathFile)) {
                        if (!chmod($this->pathFile)) {
                            Log::error("Cannot change the mode of file " . $this->pathFile . ")");
                            exit;
                        };
                    }
                }

                $realfile = $this->pathFile . $this->file;
                $this->validateFileCreatedAt($realfile);

                $this->info("Generando reporte");

                $dateRange = "Semana del {$start->day} al {$end->day} de " . App\Util\Functions::convNumberToMonth($start->month) . " {$end->year}";

                $this->html = View::make('pdf.reporte')->with('account', $this->account)->with('dateRange', $dateRange)->render();

                $pdf = \App::make('snappy.pdf.wrapper');
                $pdf->loadHTML($this->html)->setPaper('a4')->setOption('margin-bottom', 0);

                if ($pdf->save($realfile)) {
                    $this->info('Reporte Generado');
                }
            } else {
                $this->error("No se encontraron responsables para '{$this->account->nombre_cliente}'");
            }
            $this->progressbar->advance();
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
        return array(
            array('idcliente', InputArgument::REQUIRED, 'ID Cliente a generar reporte.', null),
        );
    }

    protected function getOptions()
    {
        return array();
    }
}