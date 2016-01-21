<?php

class ReporteController extends \ApiController
{
    public function processReport(Cliente $account, $type)
    {
        $data = array();
        $id   = $account->id_cliente;

        switch ($type) {
            case 'week':
                $header = '<tr>
                                <th class="col-xs-6 text-center"></th>
                                <th class="col-xs-2 text-center">Última Semana</th>
                                <th class="col-xs-2 text-center">Semana Anterior</th>
                                <th class="col-xs-2 text-center">Tendencia</th>
                            </tr>';

                $inicioActual   = Carbon::now()->subWeek()->startOfWeek();
                $finActual      = Carbon::now()->subWeek()->endOfWeek();
                $inicioAnterior = Carbon::now()->subWeeks(2)->startOfWeek();
                $finAnterior    = Carbon::now()->subWeeks(2)->endOfWeek();

                break;

            case 'month':
                $header = '<tr>
                                <th class="col-xs-6 text-center"></th>
                                <th class="col-xs-2 text-center">Último mes (acum)</th>
                                <th class="col-xs-2 text-center">Mes Anterior</th>
                                <th class="col-xs-2 text-center">Tendencia</th>
                            </tr>';

                $inicioActual   = Carbon::now()->startOfMonth();
                $finActual      = Carbon::now()->endOfMonth();
                $inicioAnterior = Carbon::now()->subMonth()->startOfMonth();
                $finAnterior    = Carbon::now()->subMonth()->endOfMonth();

                break;
        }

        // TITULO   ACTUAL  ANTERIOR    TENDENCIA
        // VISITAS
        $visita = $this->calcVisit($id, $inicioActual, $finActual, $inicioAnterior, $finAnterior);
        $data   = array_add($data, 'visitas', $visita);

        // RESPUESTAS EFECTIVAS
        $respuestas = $this->calcRespuestas($id, $inicioActual, $finActual, $inicioAnterior, $finAnterior);
        $data       = array_add($data, 'respuestasEfectivas', $respuestas);

        // TASA DE RESPUESTAS
        $tasa = $this->calcTasaRespuesta($visita, $respuestas);
        $data = array_add($data, 'tasaRespuestas', $tasa);

        //
        $v1 = \Nps::whereBetween('created_at', [$inicioActual, $finActual])->where('id_cliente', $id)->lists('promedio');
        $v2 = \Nps::whereBetween('created_at', [$inicioAnterior, $finAnterior])->where('id_cliente', $id)->lists('promedio');
        $v1 = \AdminController::genNPS2($v1);
        $v2 = \AdminController::genNPS2($v2);

        // PROMOTORES
        $promot = $this->calcPromotor($v1, $v2);
        $data   = array_add($data, 'promotores', $promot);

        // DETRACTORES
        $detract = $this->calcDetractor($v1, $v2);
        $data    = array_add($data, 'detractores', $detract);

        // NPS
        $nps  = $this->calcNps($v1, $v2);
        $data = array_add($data, 'nps', $nps);

        // LEALTAD
        $lealtad = $this->calcLealtad($id, $inicioActual, $finActual, $inicioAnterior, $finAnterior);
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
        $count = 0;
        foreach ($data as $field) {
            if (is_array($field) && count($field)) {
                if ($count != 4) {
                    if ($field[2] < 0) {
                        $color = 'red';
                    } else {
                        if ($field[2] > 0) {
                            $color = 'green';
                        } else {
                            $color = 'black';
                        }
                    }
                } else {
                    if ($field[2] > 0) {
                        $color = 'red';
                    } else {
                        if ($field[2] < 0) {
                            $color = 'green';
                        } else {
                            $color = 'black';
                        }
                    }
                }

                if ($count > 1) {
                    if ($count == 5) {
                        $body .= sprintf($tmp2, $titles[$count], $field[0] . "%", $field[1] . "%", $color, $field[2] . "%");
                    } else {
                        $body .= sprintf($tmp, $titles[$count], $field[0] . "%", $field[1] . "%", $color, $field[2] . "%");
                    }
                } else {
                    $body .= sprintf($tmp, $titles[$count], $field[0], $field[1], $color, $field[2] . "%");
                }

                $count++;
            }
        }

        return ['header' => $header, 'body' => $body];
    }

    public function calcVisit($id, $inicioActual, $finActual, $inicioAnterior, $finAnterior)
    {
        // VISITAS
        $v1 = \Visita::whereBetween('created_at', [$inicioActual, $finActual])->where('id_cliente', $id)->count();
        $v2 = \Visita::whereBetween('created_at', [$inicioAnterior, $finAnterior])->where('id_cliente', $id)->count();
        $t  = $this->calcTrend($v1, $v2);

        // TITULO   ACTUAL  ANTERIOR    TENDENCIA
        return [$v1, $v2, $t];
    }

    public function calcRespuestas($id, $inicioActual, $finActual, $inicioAnterior, $finAnterior)
    {
        $v1 = \ClienteRespuesta::whereBetween('ultima_respuesta', [$inicioActual, $finActual])->where('id_cliente', $id)->count() / 4;
        $v2 = \ClienteRespuesta::whereBetween('ultima_respuesta', [$inicioAnterior, $finAnterior])->where('id_cliente', $id)->count() / 4;
        $t  = $this->calcTrend($v1, $v2);

        // TITULO   ACTUAL  ANTERIOR    TENDENCIA
        return [$v1, $v2, $t];
    }

    public function calcTasaRespuesta($visitas, $respuesta)
    {
        try {
            $result = array();

            if (is_array($visitas) && is_array($respuesta)) {
                for ($i = 0; $i < 2; $i++) {
                    $a = $visitas[$i];
                    $b = $respuesta[$i];

                    if ($a != 0) {
                        $result[$i] = $this->roundPercent((float)($b / $a) * 100);
                    } else {
                        $result[$i] = 0;
                    }
                }

                $result[2] = $this->calcTrend($result[0], $result[1]);

                // TITULO   ACTUAL  ANTERIOR    TENDENCIA
                return $result;
            }

            return [0, 0, 0];
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function calcPromotor($v1, $v2)
    {
        if (array_key_exists('promotores', $v1) && array_key_exists('promotores', $v2)) {
            $v1 = $this->roundPercent($v1['promotores']);
            $v2 = $this->roundPercent($v2['promotores']);
            $t  = $this->calcTrend($v1, $v2);

            // TITULO   ACTUAL  ANTERIOR    TENDENCIA
            return [$v1, $v2, $t];
        }

        return [0, 0, 0];
    }

    public function calcDetractor($v1, $v2)
    {
        if (array_key_exists('detractores', $v1) && array_key_exists('detractores', $v2)) {
            $v1 = $this->roundPercent($v1['detractores']);
            $v2 = $this->roundPercent($v2['detractores']);
            $t  = $this->calcTrend($v1, $v2);

            // TITULO   ACTUAL  ANTERIOR    TENDENCIA
            return [$v1, $v2, $t];
        }

        return [0, 0, 0];
    }

    public function calcNps($v1, $v2)
    {
        if (array_key_exists('nps', $v1) && array_key_exists('nps', $v2)) {
            $v1 = $this->roundPercent($v1['nps']);
            $v2 = $this->roundPercent($v2['nps']);
            $t  = $this->calcTrend($v1, $v2);

            // TITULO   ACTUAL  ANTERIOR    TENDENCIA
            return [$v1, $v2, $t];
        }

        return [0, 0, 0];
    }

    public function calcLealtad($id, $inicioActual, $finActual, $inicioAnterior, $finAnterior)
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
            ) AS Datos ", array($id, $inicioActual, $finActual));

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
            ) AS Datos ", array($id, $inicioAnterior, $finAnterior));

        if (count($lealtad) != 0) {
            $lealtad = $lealtad[0];
            $a       = ($lealtad->Leal_SI + $lealtad->Leal_NO);
            if ($a != 0) {
                $lealtad = $this->roundPercent(($lealtad->Leal_SI / $a) * 100);
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
                $lealtadlater = $this->roundPercent(($lealtadlater->Leal_SI / $a) * 100);
            } else {
                $lealtadlater = 0;
            }
        } else {
            $lealtadlater = 0;
        }

        $t = $this->calcTrend($lealtad, $lealtadlater);

        // TITULO   ACTUAL  ANTERIOR    TENDENCIA
        return [$this->roundPercent($lealtad), $this->roundPercent($lealtadlater), $t];
    }

    public function calcTrend($v2, $v1)
    {
        try {
            if ($v1 != 0) {
                return $this->roundPercent((float)($v2 - $v1) / $v1 * 100);
            }

            return $this->roundPercent(0);
        } catch (\Exception $e) {
            Log::error($e);
        }

    }

    public function roundPercent($value, $decimals = 0)
    {
        return round($value, $decimals, PHP_ROUND_HALF_UP);
    }
}