<?php

class PdfController extends ApiController
{
    /**
     * Controlador para generacion de PDF
     * Tener en cuenta: para generacion de encuesta, usa funcion macro
     * HTML::generateSurvey($survey)
     * Si se modifica esta funcion, se debe asegurar que el PDF funcione correctamente.
     */
    public function getPdfCliente()
    {
        if (Input::has('idCliente')) {
            $cliente = Cliente::find(Input::get('idCliente'));
            //$cliente = Cliente::find(2);

            if ($cliente) {
                $directorioCliente = public_path('temp/' . $cliente->id_cliente . '/');

                $datos['cliente']    = $cliente->toArray();
                $datos['ubicacion']  = $this->getUbicacionByCiudad($cliente->id_ciudad);
                $datos['apariencia'] = $cliente->apariencias()->first()->toArray();

                $urls = $cliente->urls;

                if (!$urls->isEmpty()) {
                    try {
                        $PDFsGenerados = $this->procesaURLs($cliente, $urls, $datos, $directorioCliente);

                        if (count($PDFsGenerados) > 0) {
                            $rutaArchivoZip = $directorioCliente . "pdfs_traccion_encuesta.zip";

                            $result = $this->generaZipDePDFs($PDFsGenerados, $rutaArchivoZip, true);

                            if ($result) {
                                File::delete($PDFsGenerados);

                                return Response::download($rutaArchivoZip);
                            } else {
                                //problemas en la generacion del zip
                                echo "problemas en la generacion del zip";
                            }
                        } else {
                            //ningun pdf generado
                            echo "ningun pdf generado";
                        }
                    } catch (Exception $e) {
                        //de alguna manera mostrar error
                        //EncuestasClienteController::throwError($e);
                        echo "error en try catch: <pre>";
                        print_r($e);
                    }
                } else {
                    //no hay urls registradas
                    echo "no hay urls registradas";
                }
            } else {
                //no encontrado
                echo "cliente no encontrado";
            }
        } else {
            //faltan argumentos
            echo "faltan argumentos";
        }
    }

    public function procesaURLs($cliente, $urls, $datos, $directorioCliente)
    {
        $PDFsGenerados = array();

        $rutaEncuesta = $this->getPdfEncuesta($cliente, $datos['ubicacion']);
        if ($rutaEncuesta) {
            $PDFsGenerados[] = $rutaEncuesta;
        }

        foreach ($urls as $url) {
            $datos['url'] = $url->toArray();

            $nombreQR = $this->generaQR($directorioCliente, $cliente->id_cliente, $datos['url']['id_momento'], url($datos['url']['given']));
            if (!is_null($nombreQR)) {
                //genera tarjeta
                $PDFsGenerados[] = $this->getPdfTarjeta(
                    $cliente,
                    $datos,
                    $directorioCliente,
                    $nombreQR
                );

                //genera display
                $PDFsGenerados[] = $this->getPdfDisplay(
                    $cliente,
                    $datos,
                    $directorioCliente,
                    $nombreQR
                );
            } else {
                //problemas creando qr
            }
        }

        return $PDFsGenerados;
    }

    public function getPdfTarjeta($cliente, $datos, $directorioCliente, $nombreQR)
    {
        $datos['rutaQRAbsoluta'] = $directorioCliente . $nombreQR;
        $datos['URLrutaQR']      = 'temp/' . $cliente->id_cliente . '/' . $nombreQR;

        $textoFooter = '<p style="font-family: Arial, sans-serif;font-size:6pt;text-align:center;">';
        $textoFooter .= $cliente->direccion_cliente . ', ' . $datos['ubicacion']['ciudad'] . ' - ' . $datos['ubicacion']['pais'] . '<br />';
        $textoFooter .= isset($cliente->correo_cliente) ? $cliente->correo_cliente . '<br />' : '';
        $textoFooter .= '</p>';

        $datos['footer'] = $textoFooter;

        $html = View::make('pdf.generador.tarjeta', $datos)->render();

        $rutaPDF = $directorioCliente . 'tarjeta_' . $cliente->id_cliente . "_mom_" . $datos['url']['id_momento'] . ".pdf";
        if (File::exists($rutaPDF)) {
            File::delete($rutaPDF);
        }

        $pdf = PDF::loadHTML($html);

        $pdf->setPaper('letter');
        $pdf->setOrientation('landscape');
        $pdf->setOption('margin-left', '10mm');
        $pdf->setOption('margin-right', '10mm');
        $pdf->setOption('margin-top', '5mm');
        $pdf->setOption('margin-bottom', '10mm');
        $pdf->setOption('footer-html', false);

        $pdf->save($rutaPDF);

        return $rutaPDF;
    }

    public function getPdfDisplay($cliente, $datos, $directorioCliente, $nombreQR)
    {
        $datos['rutaQRAbsoluta'] = $directorioCliente . $nombreQR;
        $datos['URLrutaQR']      = 'temp/' . $cliente->id_cliente . '/' . $nombreQR;

        $textoFooter = '<p style="font-family: Arial, sans-serif;font-size:8pt;text-align:center;">';
        $textoFooter .= $cliente->direccion_cliente . ', ' . $datos['ubicacion']['ciudad'] . ' - ' . $datos['ubicacion']['pais'] . '<br />';
        $textoFooter .= isset($cliente->correo_cliente) ? $cliente->correo_cliente . '<br />' : '';
        $textoFooter .= '</p>';

        $rutaPDF = $directorioCliente . 'display_' . $cliente->id_cliente . "_mom_" . $datos['url']['id_momento'] . ".pdf";
        if (File::exists($rutaPDF)) {
            File::delete($rutaPDF);
        }

        $datos['footer'] = $textoFooter;

        $html = View::make('pdf.generador.display', $datos)->render();
        $pdf  = PDF::loadHTML($html);

        $pdf->setPaper('letter');
        $pdf->setOrientation('landscape');
        $pdf->setOption('margin-left', '10mm');
        $pdf->setOption('margin-right', '10mm');
        $pdf->setOption('margin-top', '5mm');
        $pdf->setOption('margin-bottom', '10mm');
        $pdf->setOption('footer-html', false);

        $pdf->save($rutaPDF);

        return $rutaPDF;

    }

    public function getPdfEncuesta($cliente, $ubicacion)
    {
        $html = $this->generaEncuestaHTML($cliente);

        if ($html == false) {
            return false;
        } else {
            //echo $html;
            $pdf = PDF::loadHTML($html);

            $textoFooter = '<p style="font-family: Arial, sans-serif;font-size:8pt;text-align:center;">';
            $textoFooter .= $cliente->direccion_cliente . ', ' . $ubicacion['ciudad'] . ' - ' . $ubicacion['pais'] . '<br/>';
            $textoFooter .= isset($cliente->fono_fijo_cliente) ? $cliente->fono_fijo_cliente : '';
            $textoFooter .= isset($cliente->fono_celular_cliente) ? ' | ' . $cliente->fono_celular_cliente . '<br/>' : isset($cliente->fono_fijo_cliente) ? '<br/>' : '';
            $textoFooter .= isset($cliente->correo_cliente) ? $cliente->correo_cliente . '<br/>' : '';
            $textoFooter .= '</p>';
            /*$pdf->setOption('page-width', '14.5cm');
            $pdf->setOption('page-height', '21cm');
            $pdf->setOption('margin-left', '10mm');
            $pdf->setOption('margin-right', '10mm');
            $pdf->setOption('margin-top', '10mm');
            $pdf->setOption('margin-bottom', '10mm');*/
            $pdf->setPaper('letter');
            $pdf->setOrientation('portrait');
            $pdf->setOption('margin-left', '10mm');
            $pdf->setOption('margin-right', '10mm');
            $pdf->setOption('margin-top', '10mm');
            $pdf->setOption('margin-bottom', '15mm');
            $pdf->setOption('footer-html', $textoFooter);
            //$pdf->setOption("disable-smart-shrinking", true);

            $directorioCliente = public_path('temp/' . $cliente->id_cliente . '/');

            $rutaPdf = $directorioCliente . 'encuesta_' . $cliente->id_cliente . ".pdf";
            if (File::exists($rutaPdf)) {
                File::delete($rutaPdf);
            }

            $pdf->save($rutaPdf);

            //return $pdf->stream();
            return $rutaPdf;
        }
    }

    public function getUbicacionByCiudad($idCiudad)
    {
        $ubicacion = [];
        $ciudad    = Ciudad::find($idCiudad);
        if ($ciudad) {
            $ubicacion['ciudad'] = $ciudad->descripcion_ciudad;

            $region = Region::find($ciudad->id_region);
            if ($region) {
                $ubicacion['region'] = $region->descripcion_region;

                $pais = Pais::find($region->id_pais);
                if ($pais) {
                    $ubicacion['pais'] = $pais->descripcion_pais;
                }
            }
        }

        return $ubicacion;
    }

    public function generaQR($directorioCliente, $idCliente, $idMomento, $contenidoQR)
    {
        $nombreQR = null;
        if (!\File::exists($directorioCliente)) {
            // $creoDirectorio = \File::makeDirectory($directorioCliente);
            $creoDirectorio =  mkdir($directorioCliente, 2777, true);

            if ($creoDirectorio) {
                $nombreQR = $idMomento . '.png';
            }
        } else {
            $nombreQR = $idMomento . '.png';
        }

        if (!is_null($nombreQR)) {
            if (!\File::exists($directorioCliente . $nombreQR)) {
                parent::createQrCode($directorioCliente . $nombreQR, $contenidoQR);
            }
        }

        return $nombreQR;
    }

    //private function generaEncuestaHTML($idcliente = null){
    public function generaEncuestaHTML($client)
    {
        if (isset($client)) {
            //try {
            //$client = Cliente::find($idcliente);

            if (!is_null($client) && $client->first()->exists) {

                if (!is_null($client->plan)) {
                    $survey = $client->encuesta;
                    $theme  = $client->theme();

                    if (!Session::has('survey.theme')) {
                        Session::put('survey.theme', $theme);
                    }

                    if (!Session::has('survey.survey')) {
                        Session::put('survey.survey', $survey);
                    }

                    if (!Session::has('survey.client')) {
                        Session::put('survey.client', $client);
                    }
                }

                return View::make('pdf.generador.encuesta')
                           ->withTheme($theme)
                           ->withSurvey($survey)
                           ->withClient($client)
                           ->render();
            } else {
                return false;
            }

            /*} catch (Exception $e) {
                return EncuestasClienteController::throwError($e);
            }*/
        } else {
            return false;
        }

        //return Redirect::to('survey/error');
    }

    private function generaZipDePDFs($files = array(), $destination = '', $overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if (\File::exists($destination)) {
                $overwrite = ZIPARCHIVE::OVERWRITE;
            } else {
                $overwrite = ZIPARCHIVE::CREATE;
            }
            $open = $zip->open($destination, $overwrite);
//            $open = $zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE);
            if ($open !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                //$zip->addFile($file,$file);
                $zip->addFile($file, File::name($file) . '.' . File::extension($file));
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }
}