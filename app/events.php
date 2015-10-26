<?php

Event::listen('ya_respondio', function () {
    if (ClienteRespuesta::hasRequests()) {
        $resp = ClienteRespuesta::whereIdCliente(array(Auth::user()->id_cliente))->whereRaw('MONTH(ultima_respuesta) = MONTH(CURRENT_DATE) AND YEAR(ultima_respuesta) = YEAR(CURRENT_DATE)')->orderBy('id_cliente_respuesta',
            'DESC')->first(array('ultima_respuesta'));
        if (!is_null($resp->ultima_respuesta)) {
            Session::put('ya_respondio', true);

            return $last_responsed = new Carbon($resp->ultima_respuesta);
        }
        unset($resp);
    }

    return null;
});