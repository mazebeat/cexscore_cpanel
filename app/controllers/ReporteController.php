<?php

class ReporteController extends \ApiController
{
    /**
     * @param $account
     * @param $type
     */
    public function processReport(Cliente $account, $type)
    {
        $data = array();

        switch ($type) {
            case 'week':
                $header = '<tr>
                                <th class="col-xs-6 text-center"></th>
                                <th class="col-xs-2 text-center">Última Semana</th>
                                <th class="col-xs-2 text-center">Semana Anterior</th>
                                <th class="col-xs-2 text-center">Variación</th>
                            </tr>';

                $start      = Carbon::now()->startOfWeek();
                $end        = Carbon::now()->endOfWeek();
                $startlater = Carbon::now()->subWeek()->startOfWeek();
                $endlater   = Carbon::now()->subWeek()->endOfWeek();

                break;

            case 'month':
                $header = '<tr>
                                <th class="col-xs-6 text-center"></th>
                                <th class="col-xs-2 text-center">Último mes (acum)</th>
                                <th class="col-xs-2 text-center">Mes Anterior</th>
                                <th class="col-xs-2 text-center">Variación</th>
                            </tr>';

                $start      = Carbon::now()->startOfMonth();
                $end        = Carbon::now()->endOfMonth();
                $startlater = Carbon::now()->subMonth()->startOfMonth();
                $endlater   = Carbon::now()->subMonth()->endOfMonth();

                break;
        }

        $visita = $this->calcVisit($account, $start, $end, $startlater, $endlater);
        $data   = array_add($data, 'visitas', $visita);

        // RESPUESTAS EFECTIVAS
        $data = array_add($data, 'respuestasEfectivas', [0, 0, 0]);

        // TASA DE RESPUESTAS
        $tasa = $this->calcTasaRespuesta($account, $start, $end, $startlater, $endlater);
        $data = array_add($data, 'tasaRespuestas', $tasa);

        // NPS
        $nps  = $this->calcNps($account, $start, $end, $startlater, $endlater);
        $data = array_add($data, 'nps', $nps);

        // DETRACTORES
        $detract = $this->calcDetractor($account, $start, $end, $startlater, $endlater);
        $data    = array_add($data, 'detractores', $detract);

        // PROMOTORES
        $promot = $this->calcPromotor($account, $start, $end, $startlater, $endlater);
        $data   = array_add($data, 'promotores', $promot);

        // LEALTAD
        $lealtad = $this->calcLealtad($account, $start, $end, $startlater, $endlater);
        $data    = array_add($data, 'lealtad', $lealtad);

        $titles = [
            'Visitas al sistema de respuesta',
            'Respuestas efectivas',
            'Tasa de respuesta',
            'Promotores %',
            'Detractores %',
            'NPS',
            'Lealtad',
        ];

        $tmp = "<tr>
                <td class='text-left'>%s</td>
                <td class='text-center'>%s</td>
                <td class='text-center'>%s</td>
                <td class='text-center' style='color: %s'>%s</td>
           </tr>";

        $tmp2 = "<tr class='' style='font-weight: bold;'>
                <td class='text-left'>%s</td>
                <td class='text-center'>%s</td>
                <td class='text-center'>%s</td>
                <td class='text-center' style='color: %s'>%s</td>
           </tr>";

        $body  = '';
        $color = '';
        $count = 0;
        foreach ($data as $key => $value) {
            if ($value[2] < 0) {
                $color = 'red';
            } else if ($value[2] > 0) {
                $color = 'green';
            } else {
                $color = 'black';
            }

            if ($count == 5) {
                $body .= sprintf($tmp2, $titles[$count], $value[0], $value[1], $color, $value[2] . "%");
            } else {
                $body .= sprintf($tmp, $titles[$count], $value[0], $value[1], $color, $value[2] . "%");
            }

            $count++;
        }

        return ['header' => $header, 'body' => $body];
    }

    /**
     * @param $account
     * @param $start
     * @param $end
     * @param $startlater
     * @param $endlater
     *
     * @return array
     */
    public function calcVisit($account, $start, $end, $startlater, $endlater)
    {
        // VISITAS
        $a = \Visita::whereBetween('created_at', [$start, $end])->where('id_cliente', $account->id_cliente)->count();
        $b = \Visita::whereBetween('created_at', [$startlater, $endlater])->where('id_cliente', $account->id_cliente)->count();
        $c = \ApiController::calcVariacion($a, $b);

        return [$a, $b, $c,];
    }

    public function calcTasaRespuesta($account, $start, $end, $startlater, $endlater)
    {
        $a = (int)\Respuesta::select(\DB::raw('ROUND(COUNT(id_respuesta)/4) as cant'))->whereBetween('created_at', [$start, $end])->first(['cant'])->cant;
        $b = (int)\Respuesta::select(\DB::raw('ROUND(COUNT(id_respuesta)/4) as cant'))->whereBetween('created_at', [$startlater, $endlater])->first(['cant'])->cant;
        $c = \ApiController::calcVariacion($a, $b);

        return [$a, $b, $c];
    }

    public function calcNps($account, $start, $end, $startlater, $endlater)
    {
        $a = \AdminController::genNPS2(\Nps::whereBetween('created_at', [$start, $end])->where('id_cliente', $account->id_cliente)->lists('promedio'));
        $b = \AdminController::genNPS2(\Nps::whereBetween('created_at', [$startlater, $endlater])->where('id_cliente', $account->id_cliente)->lists('promedio'));
        $c = \ApiController::calcVariacion($a['nps'], $b['nps']);

        return [round($a['nps'], 1, PHP_ROUND_HALF_UP), round($b['nps'], 1, PHP_ROUND_HALF_UP), $c];

        // DETRACTORES
        $detractvars = \ApiController::calcVariacion($a['detractores'], $b['detractores']);

        return [round($a['detractores'], 1, PHP_ROUND_HALF_UP), round($b['detractores'], 1, PHP_ROUND_HALF_UP), $detractvars];

        // PROMOTORES
        $promotovars = \ApiController::calcVariacion($a['promotores'], $b['promotores']);

        return [round($a['promotores'], 1, PHP_ROUND_HALF_UP), round($b['promotores'], 1, PHP_ROUND_HALF_UP), $promotovars];

    }

    /**
     * @param $account
     * @param $start
     * @param $end
     * @param $startlater
     * @param $endlater
     *
     * @return array
     * @throws \Exception
     */
    public function calcPromotor($account, $start, $end, $startlater, $endlater)
    {
        $a = \AdminController::genNPS2(\Nps::whereBetween('created_at', [$start, $end])->where('id_cliente', $account->id_cliente)->lists('promedio'));
        $b = \AdminController::genNPS2(\Nps::whereBetween('created_at', [$startlater, $endlater])->where('id_cliente', $account->id_cliente)->lists('promedio'));

        // PROMOTORES
        $promotovars = \ApiController::calcVariacion($a['promotores'], $b['promotores']);

        return [round($a['promotores'], 1, PHP_ROUND_HALF_UP), round($b['promotores'], 1, PHP_ROUND_HALF_UP), $promotovars];

    }

    /**
     * @param $account
     * @param $start
     * @param $end
     * @param $startlater
     * @param $endlater
     *
     * @return array
     * @throws \Exception
     */
    public function calcDetractor($account, $start, $end, $startlater, $endlater)
    {
        $a = \AdminController::genNPS2(\Nps::whereBetween('created_at', [$start, $end])->where('id_cliente', $account->id_cliente)->lists('promedio'));
        $b = \AdminController::genNPS2(\Nps::whereBetween('created_at', [$startlater, $endlater])->where('id_cliente', $account->id_cliente)->lists('promedio'));

        // DETRACTORES
        $detractvars = \ApiController::calcVariacion($a['detractores'], $b['detractores']);

        return [round($a['detractores'], 1, PHP_ROUND_HALF_UP), round($b['detractores'], 1, PHP_ROUND_HALF_UP), $detractvars];
    }

    /**
     * @param $account
     * @param $start
     * @param $end
     * @param $startlater
     * @param $endlater
     *
     * @return array
     */
    public function calcLealtad($account, $start, $end, $startlater, $endlater)
    {
        $lealtad = \DB::select("SELECT
            SUM(CASE WHEN valor2 = 'NO' THEN 1 ELSE 0 END) AS Leal_NO,
            SUM(CASE WHEN valor2 = 'SI' THEN 1 END) AS Leal_SI
            FROM (
                SELECT respuesta.id_cliente, respuesta_detalle.valor2
                FROM cliente
                INNER JOIN cliente_respuesta
                ON cliente.id_cliente = cliente_respuesta.id_cliente
                INNER JOIN respuesta
                ON cliente_respuesta.id_respuesta = respuesta.id_respuesta
                INNER JOIN respuesta_detalle
                ON respuesta.id_respuesta = respuesta_detalle.id_respuesta
                INNER JOIN pregunta_cabecera
                ON respuesta.id_pregunta_cabecera = pregunta_cabecera.id_pregunta_cabecera
                INNER JOIN (
                    SELECT cliente_respuesta.id_cliente,
                    MAX(cliente_respuesta.id_cliente_respuesta) AS id_ultima_rpta
                    FROM cliente_respuesta
                    INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente
                    GROUP BY id_cliente
                ) AS Ultima_rpta_x_usuario
                ON cliente_respuesta.id_cliente = Ultima_rpta_x_usuario.id_cliente
                WHERE (pregunta_cabecera.numero_pregunta = 4)
                AND cliente.id_cliente = ?
                AND cliente_respuesta.ultima_respuesta BETWEEN ? AND ?
            ) AS Datos ", array($account->id_cliente, $start, $end));

        $lealtadlater = \DB::select("SELECT
            SUM(CASE WHEN valor2 = 'NO' THEN 1 ELSE 0 END) AS Leal_NO,
            SUM(CASE WHEN valor2 = 'SI' THEN 1 END) AS Leal_SI
            FROM (
                SELECT respuesta.id_cliente, respuesta_detalle.valor2
                FROM cliente
                INNER JOIN cliente_respuesta
                ON cliente.id_cliente = cliente_respuesta.id_cliente
                INNER JOIN respuesta
                ON cliente_respuesta.id_respuesta = respuesta.id_respuesta
                INNER JOIN respuesta_detalle
                ON respuesta.id_respuesta = respuesta_detalle.id_respuesta
                INNER JOIN pregunta_cabecera
                ON respuesta.id_pregunta_cabecera = pregunta_cabecera.id_pregunta_cabecera
                INNER JOIN (
                    SELECT cliente_respuesta.id_cliente,
                    MAX(cliente_respuesta.id_cliente_respuesta) AS id_ultima_rpta
                    FROM cliente_respuesta
                    INNER JOIN cliente ON cliente.id_cliente = cliente_respuesta.id_cliente
                    GROUP BY id_cliente
                ) AS Ultima_rpta_x_usuario
                ON cliente_respuesta.id_cliente = Ultima_rpta_x_usuario.id_cliente
                WHERE (pregunta_cabecera.numero_pregunta = 4)
                AND cliente.id_cliente = ?
                AND cliente_respuesta.ultima_respuesta BETWEEN ? AND ?
            ) AS Datos ", array($account->id_cliente, $startlater, $endlater));

        if (count($lealtad) != 0) {
            $lealtad = $lealtad[0];
            $a       = ($lealtad->Leal_SI + $lealtad->Leal_NO);
            if ($a != 0) {
                $lealtad = round((($lealtad->Leal_SI / $a) * 100), 1, PHP_ROUND_HALF_UP);
            } else {
                $lealtad = 0;
            }
        } else {
            $lealtad = 0;
        }
        if (count($lealtadlater) != 0) {
            $lealtadlater = $lealtadlater[0];
            $a            = ($lealtadlater->Leal_SI + $lealtadlater->Leal_NO);
            if ($a != 0) {
                round($lealtadlater = (($lealtadlater->Leal_SI / $a) * 100), 1, PHP_ROUND_HALF_UP);
            } else {
                $lealtadlater = 0;
            }
        } else {
            $lealtadlater = 0;
        }

        $lealvari = \ApiController::calcVariacion($lealtad, $lealtadlater);

        return [round($lealtad, 1, PHP_ROUND_HALF_UP), round($lealtadlater, 1, PHP_ROUND_HALF_UP), $lealvari];
    }
}