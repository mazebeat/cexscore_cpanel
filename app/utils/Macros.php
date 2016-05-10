<?php namespace App\Util;

/**
 * -------------------------------------
 *             NAV Macros
 * -------------------------------------
 */
\HTML::macro('isActive', function ($path, $active = 'active') {
    $request = \Request::path();
    if (!starts_with($request, '/')) {
        $request = '/' . $request;
    }
    $contain = \Str::contains($request, $path);

    return $contain ? $active : '';
});

\HTML::macro('isActiveList', function ($paths = array(), $active = 'active') {
    if (is_array($paths)) {
        foreach ($paths as $path) {
            if (\HTML::isActive($path) != '') {
                return $active;
            }
        }
    }

    return '';
});


/**
 * -------------------------------------
 *              STRING MACROS
 * -------------------------------------
 *
 */

\Str::macro('hes', function ($str) {
    $find    = array("á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ");
    $replace = array(
        "&aacute;",
        "&eacute;",
        "&iacute;",
        "&oacute;",
        "&uacute;",
        "&ntilde;",
        "&Aacute;",
        "&Eacute;",
        "&Iacute;",
        "&Oacute;",
        "&Uacute;",
        "&Ntilde;",
    );

    return str_replace($find, $replace, $str);
    //return htmlentities($str, ENT_QUOTES, "UTF-8");
});
/**
 * -------------------------------------
 *              FORMS MACROS
 * -------------------------------------
 *
 */
//    {{ Form::select2('cliente[id_sector]', $sectors, Input::old('cliente[id_sector]'), array('id'=> 'id_sector', 'class'=>'form-control', 'required')) }}

\Form::macro('select2', function ($name, $list = [], $selected = null, $options = [], $disabled = []) {
    $options = \HTML::attributes($options);
    $html    = '<select name="' . $name . '" ' . $options . '>';

    $html .= '<option value=""></option>';

    foreach ($list as $value => $text) {
        $html .= '<option value="' . $value . '"' .
                 ($value == $selected ? ' selected="selected"' : '') .
                 (in_array($value, $disabled) ? ' disabled="disabled"' : '') . '>' .
                 $text . '</option>';
    }
    $html .= '</select>';

    return $html;
});

\Form::macro('radio_scale', function ($data = array(), $max_number = 0, $order = 'ASC', $options = array()) {
    $output = '';
    $header = '';
    $body   = '';
    $name   = array_get($data, 'name', 'default');
    $header .= '<div class="table-responsive hidden-xs hidden-sm"><table class="table table-hover table-condensed"><thead class="text-center"><tr><td></td>';
    for ($i = 1; $i <= $max_number; $i++) {
        $header .= '<td>' . $i . '</td>';
    }
    $header .= '</tr></thead><tbody class="text-center"><tr><td class="text-left">' . $name . '</td>';
    switch (\Str::upper($order)) {
        case 'ASC':
            for ($i = 1; $i <= $max_number; $i++) {
                $body .= '<td>' . \Form::radio('name', $i, false, $options) . '</td>';
            }
            break;
        case 'DESC':
            for ($i = $max_number; $i >= 1; $i--) {
                $body .= '<td>' . \Form::radio('name', $i, false, array('required' => 'required')) . '</td>';
            }
            break;
    }
    $body .= '</tr></tbody></table>';

    echo $header . $body;
});

\Form::macro('bsRadioForm', function ($name, $data = array(), $old = null, $options = array()) {
    $out   = '';
    $count = 0;
    foreach ($data as $key => $value) {
        ($old == $key) ? $cheked = 'checked' : '';
        $out .= '<div class="radio">
              <label>
                <input type="radio" name="' . $name . '" id="' . $name . $count . '" value="' . $key . '" ' . $old . '>&nbsp;' . $value . '</label>
            </div>';
        $count++;
    }

    return $out;

});

\Form::macro('selectRange2', function ($name, $begin, $end, $selected = null, $options = array()) {

    $list  = '<option></option>';
    $range = array_combine($range = range($begin, $end), $range);

    foreach ($range as $key => $value) {
        $list .= "<option value='$key'>$value</option>";
    }

    $options = \HTML::attributes($options);
    unset($range);

    return '<select name=' . e($name) . ' ' . $options . '>' . $list . '</select> ';
});

/** ---------------------------------------------------------------------------------------------------------------------------- */
/**
 * -------------------------------------
 *              HTML MACROS
 * -------------------------------------
 *
 */
/**
 * GENERATE TABLE
 */
\HTML::macro('tableize', function ($name, $structure, $data, $headers = true, $options = array()) {

    $html = '';

    if ($headers) {
        $html .= '<table id="detailTable" name = ' . e($name) . ' ' . \HTML::attributes($options) . '>';
        $html .= '<thead class="text-center">';
        $html .= '<tr>';
        foreach ($structure as $title) {
            $html .= '<th>' . utf8_decode($title) . '</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
    }

    foreach ($data as $item) {
        $html .= '<tr>';
        foreach ($structure as $key => $value) {
            $html .= '<td>' . utf8_decode($item->$key) . '</td>';
        }
        $html .= '</tr>';
    }

    if ($headers) {
        $html .= '</tbody>';
        $html .= '</table>';
    }

    return $html;
});

/**
 * CREATE ALERT TYPE BOOTSTRAP
 */
\HTML::macro('create_alert', function ($data = array(), $options = array()) {

    if (!count($data) || $data === '' || $data == 0) {
        return;
    }
    if (!count($options) || $options === '' || $options == 0) {
        $options = null;
    }
    $title    = array_get($data, 'title', null);
    $subtitle = array_get($data, 'subtitle', null);
    $text     = array_get($data, 'text', null);
    $type     = array_get($data, 'type', null);
    switch ($type) {
        case 'danger':
            $type = 'alert-danger';
            break;
        case 'info':
            $type = 'alert-info';
            break;
        case 'success':
            $type = 'alert-success';
            break;
        case 'warning':
            $type = 'alert-warning';
            break;
        default:
            break;
    }
    $output = ' <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2"><div role = "alert" class="alert ' . $type . ' fade in"><button data-dismiss = "alert" class="close" type = "button"><i class="fa fa-times"></i></button>';
    $output .= isset($title) ? '<h4>' . \Str::hes($title) . '</h4>' : '';
    $output .= isset($subtitle) ? '<h5>' . \Str::hes($subtitle) . '</h5>' : '';
    $output .= isset($text) ? '<p>' . \Str::hes($text) . ' </p>' : '';
    if (isset($options)) {
        $output .= '<p>';
        foreach ($options as $option) {
            $output .= $option;
        }
        $output .= '</p>';
    }
    $output .= '<p class="clearfix"></div></div>';

    echo $output;
});

/**
 * BOOTSTRAP ALERT WITH AUTOMATIC HIDDEN JS
 */
\HTML::macro('alert', function ($type, $messages = array(), $head = null) {
    $message = '';
    foreach ($messages as $value) {
        $message .= $value . ' <br>';
    }
    $script = '<script type="text / javascript">
    	setTimeout(function () {
    		jq(" . errors").hide(2000, function() {
    			jq(this).remove();
    		});
    }, 10000);
    </script> ';

    return '<div class="errors alert alert-' . $type . '"><h5><strong> ' . \Str::hes($head) . '</strong></h5>' . \Str::hes($message) . '</div>' . $script;
});

/**
 * RESPONSIVE MULTI OPTIONS
 */
\HTML::macro('responsiveOpt', function (\PreguntaCabecera $question, $max = 7, $isSubQuestion = false, $text = 'Calificaci&oacute;n') {
    $responsive = array(
        'class'                    => 'form-control',
        'data-placeholder'         => '...',
        'data-fv-notempty',
        'data-fv-notempty-message' => \Lang::get('validation.required', ['attribute' => '']),
    );

    //Debugbar::addMessage('RESPONSIVEOPTION | ID PREGUNTA: ' . $question->id_pregunta_cabecera . ' NUMERO PREGUNTA: ' . $question->numero_pregunta);

    return '<div class="form-group table-responsive hidden-md hidden-lg">
    	<table class="table table-hover table-condensed">
    		<thead class="text-center">
    			<tr>
    				<td></td>
    				<td></td>
    			</tr>
    		</thead>
    		<tbody class="text-center">
    			<tr>
    				<td class="text-left vertical-align">
    					<label class="control-label">' . $text . '</label>
    				</td>
    				<td class="">' . \Form::selectRange2('question_' . $question->numero_pregunta . '_' . $question->id_pregunta_cabecera . '[value]', '1', $max, null, $responsive) . '</td>
    			</tr>
    		</tbody>
    	</table>
    </div>';
});

/**
 * MULTI OPTIONS
 */
\HTML::macro('multiOptions', function (\PreguntaCabecera $question, $isSubQuestion = false) {
    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('MULTIOPTIONS | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    return $out;
});

/**
 * SINGLE OPTIONS
 */
\HTML::macro('singleOptions', function (\PreguntaCabecera $question, $max = 7, $isSubQuestion = false, $text = 'Calificaci&oacute;n') {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('SINGLEOPTIONS | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    if (isset($max) && $max > 0) {
        $out .= \HTML::responsiveOpt($question, $max, $isSubQuestion);
        $out .= '<div class="form-group table-responsive hidden-xs hidden-sm">
		<table class="table table-hover table-condensed">
			<thead class="text-center">
				<tr>
					<td></td>';

        for ($i = 1; $i <= $max; $i++) {
            $out .= '<td class="text-center">' . $i . '</td>';
        }

        $out .= '</tr>
				</thead>
				<tbody class="text-center">
					<tr>
						<td class="text-left vertical-align">
							<label class="control-label">' . $text . '</label>
						</td>';

        for ($i = 1; $i <= $max; $i++) {
            if ($i == 1) {
                $out .= '<td>
								<input type="radio" class=""  name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[value]" value="' . $i . '"  data-fv-notempty data-fv-notempty-message="' . \Lang::get('validation . required',
                        ['attribute' => '']) . '" data-fv-choice="true">
							</td>';
            } else {
                $out .= '<td>
							<input type="radio" class=""  name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[value]" value="' . $i . '">
						</td>';
            }
        }

        $out .= '</tr></tbody></table>';
        $out .= '</div>';
        $out .= '<div class="messageContainer"></div>';
    } else {
        $out .= \HTML::alert('warning', array('Cantidad de opciones no declarada en la función.'), 'ATENCIÓN!...');
    }

    return $out;
});

/**
 * TEXT OPTIONS
 */
\HTML::macro('textOptions', function (\PreguntaCabecera $question, $multi, $isSubQuestion = false) {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $textarea          = array(
            'placeholder'                  => '...',
            'class'                        => 'form-control',
            'rows'                         => 3,
            'length'                       => 250,
            'data-fv-stringlength'         => 'true',
            'data-fv-stringlength-min'     => 0,
            'data-fv-stringlength-max'     => 250,
            'data-fv-stringlength-message' => \Lang::get('validation.max.string', ['attribute' => '', 'max' => 250]),
        );
        $textbox           = array(
            'placeholder' => '...',
            'class'       => 'form-control',
        );
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $textarea          = array(
            'placeholder'                  => '...',
            'class'                        => 'form-control',
            'rows'                         => 3,
            'length'                       => 300,
            'data-fv-notempty'             => true,
            'data-fv-notempty-message'     => Lang::get('validation.required', ['attribute' => '']),
            'data-fv-stringlength'         => true,
            'data-fv-stringlength-min'     => 0,
            'data-fv-stringlength-max'     => 250,
            'data-fv-stringlength-message' => Lang::get('validation.max.string', ['attribute' => '', 'max' => 250]),
        );
        $textbox           = array(
            'placeholder' => '...',
            'class'       => 'form-control',
        );
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('TEXTOPTION | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    $out .= '<div class="form-group">';

    if ($multi) {
        $out .= \Form::textarea('question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]', null, $textarea);
        $out .= '<small class="count"></small>';
    } else {
        $out .= \Form::text('question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]', null, $textbox);
        $out .= '<small class="count"></small>';
    }

    //$out .= '<div class="messageContainer"></div>';
    $out .= '</div>';

    return $out;
});

/**
 * RANGE OPTIONS
 */
\HTML::macro('rangeOptions', function (\PreguntaCabecera $question, $isSubQuestion = false) {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    $out .= '<div class="form-group">';
    // ...
    //$out .= '<div class="messageContainer"></div>';
    $out .= '</div>';

    return $out;
});

/**
 * BOOLEAN OPTIONS
 */
\HTML::macro('booleanOptions', function (\PreguntaCabecera $question, $isSubQuestion = false) {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('BOOLEANOPTION | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    $out .= '<div class="form-group table-responsive">
	<table class="table table-hover table-condensed">
		<thead class="text-center">
			<tr>
				<td style="width: 33 %;"></td>
				<td style="width: 33 %;">' . \Str::hes(\Lang::get('messages.yes')) . '</td>
				<td style="width: 33 %;">' . \Str::hes(\Lang::get('messages.no')) . '</td>
			</tr>
		</thead>
		<tbody class=" text-center">
			<tr class="">
				<td style="width: 33 %;" class="text-left vertical-align"><label class="control-label">' . \Str::hes('Opción') . '</label></td>
				<td style="width: 33 %;"><input type="radio" name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]" value="SI" data-fv-notempty data-fv-notempty-message="' . \Lang::get('validation . required',
            ['attribute' => '']) . '"></td>
				<td style="width: 33 %;"><input type="radio" name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]" value="NO"></td>
			</tr>
		</tbody>
	</table>';
    $out .= '</div>';
    $out .= '<div class="messageContainer"></div>';

    return $out;
});

/**
 * CREATE ALL QUESTIONS
 */
\HTML::macro('createQuestions', function (\PreguntaCabecera $question, $isSubQuestion = false) {
    $out = '';

    if (!$isSubQuestion) {
        $out = '<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    }

    //dd($question->id_tipo_respuesta);
    switch ($question->id_tipo_respuesta) {
        case 1:
            //Opcion única
            $out .= \HTML::singleOptions($question, 7, $isSubQuestion);
            break;
        case 2:
            //Multiopción
            $out .= \HTML::multiOptions($question, $isSubQuestion);
            break;
        case 3:
            //Por rango de valor
            $out .= \HTML::rangeOptions($question, $isSubQuestion);
            break;
        case 4:
            //Respuesta texto (Linea simple)
            $out .= \HTML::textOptions($question, false, $isSubQuestion);
            break;
        case 5:
            //Respuesta texto (Multilinea)
            $out .= \HTML::textOptions($question, true, $isSubQuestion);
            break;
        case 6:
            //Booleana
            $out .= \HTML::booleanOptions($question, $isSubQuestion);
            break;
    }

    //$subQuestion = PreguntaCabecera::select(array('id_pregunta_cabecera', 'descripcion_1', 'numero_pregunta', 'id_pregunta_padre', 'id_tipo_respuesta'))->whereIdPreguntaPadre($question->id_pregunta_cabecera)->whereNumeroPregunta(null)->first(array('id_pregunta_cabecera', 'descripcion_1', 'numero_pregunta', 'id_pregunta_padre', 'id_tipo_respuesta'));
    $subQuestion = \PreguntaCabecera::whereIdPreguntaPadre($question->id_pregunta_cabecera)->whereNumeroPregunta(null)->first();

    if (!is_null($subQuestion)) {
        $out .= \HTML::createQuestions($subQuestion, true);
    }

    if (!$isSubQuestion) {
        $out .= '</article>';
    }

    return $out;
});

/**
 * GENERATE SURVEY
 */
\HTML::macro('generateSurvey', function ($survey = null) {

    if (!isset($survey) && !$survey->exists) {
        return \HTML::alert('danger', array('No existe encuesta asociada.'), 'Atención!...');
    }

    $questions = $survey->preguntas;

    if (count($questions) <= 0) {
        return \HTML::alert('warning', array('No existen preguntas para esta encuesta.'), 'Atención!...');
    }

    //$options_count = 7;
    $out = '';
    foreach ($questions as $key => $question) {
        if ($question->id_pregunta_padre === null) {
            $out .= \HTML::createQuestions($question);
        }
    }

    return $out;
});

/** ---------------------------------------------------------------------------------------------------------------------------- */
/**
 * ---------------------------
 *  FORM ADD OR MODIFY SURVEY
 * ---------------------------
 */
\Form::macro('loadSurvey', function (\Encuesta $survey, $isMy = false) {
    //\Form::macro('loadSurvey', function (\Encuesta $survey, $idplan = 1) {

    $out      = '';
    $readonly = false;

    //    $idpplan = \Plan::select('id_plan')->where('descripcion_plan', 'LIKE', '%free%')->first('id_plan')->id_plan;
    //    if ((int)$idplan == (int)$idpplan) {
    if (!$isMy) {
        $readonly = true;
    }

    if (!isset($survey) && !$survey->exists) {
        return \HTML::alert('danger', array('No existe encuesta asociada.'), 'Atenci&oacute;n!...');
    }

    $questions = $survey->preguntas;

    if (count($questions) <= 0) {
        return \HTML::alert('warning', array('No existen preguntas para esta encuesta.'), 'Atenci&oacute;n!...');
    }

    $count = 1;
    foreach ($questions as $key => $question) {
        if ($question->id_pregunta_padre === null) {
            $name = $count++ . '.- ' . \Categoria::find($question->id_categoria)->descripcion_categoria;
            $out .= \Form::generateInput($name, $question, $readonly);
        }
    }

    return $out;
});
\Form::macro('generateInput', function ($title, \PreguntaCabecera $question, $readonly = false) {
    $ro = '';

    if ($readonly) {
        $ro = 'readonly';
    }

    $out = '<div class="form-group">';
    $out .= '<div class="col-sm-12">';
    $out .= '<h4>' . \Form::label('question' . $question->id_pregunta_cabecera, $title) . '</h4>';
    $out .= \Form::textarea('question' . $question->id_pregunta_cabecera, trim($question->descripcion_1), ['class' => 'form-control ckeditor', $ro]);
    $out .= '</div>';
    $out .= '</div>';

    return $out;
});

\HTML::macro('getMainQuestion', function ($text, $number = 0) {

    if (\Str::contains($text, '<p><strong>') && $number < 4) {
        $text = str_replace('<p><strong>', '<br><strong>', $text);
    } elseif (\Str::contains($text, '<p><strong>') && $number == 4) {
        $text = str_replace('<p><strong>', '<strong>', $text);
    }

    if (\Str::contains($text, '<p>')) {
        $text = str_replace('<p>', '', $text);
        $text = str_replace('</p>', '', $text);
    }

    if (isset($number) && $number != 0) {
        $text = '<h4>' . \Str::hes($number . '.- ' . $text) . '</h4>';
    } else {
        $text = '<h4>' . \Str::hes($text) . '</h4>';
    }

    return $text;
});
\HTML::macro('getSubQuestion', function ($text, $number = 0) {

    if (\Str::contains($text, '<p><strong>') && $number < 4) {
        $text = str_replace('<p><strong>', '<br><strong>', $text);
    } elseif (\Str::contains($text, '<p><strong>') && $number == 4) {
        $text = str_replace('<p><strong>', '<strong>', $text);
    }

    if (\Str::contains($text, '<p>')) {
        $text = str_replace('<p>', '', $text);
        $text = str_replace('</p>', '', $text);
    }

    if (isset($number) && $number != 0) {
        $text = '<h5>' . \Str::hes($number . '.- ' . $text) . '</h5>';
    } else {
        $text = '<h5>' . \Str::hes($text) . '</h5>';
    }

    return $text;
});
\Form::macro('questionForm', function ($name, $questionNumber = 0, $isSubQuestion = false, $category = null, $readyonly = false) {

    $out  = '';
    $kind = 1;
    $sub  = '';

    if ($isSubQuestion) {
        $sub = '[sub]';
        if ($questionNumber == 4) {
            $kind = 6;
        } else {
            $kind = 5;
        }
    }

    if ($readyonly) {
        $readyonly = 'readonly';
    }

    if ($category == null) {
        return \HTML::alert('warning', ['Categoría no encontrada.'], '<h3>Atención!</h3>');
    }

    $n = $name . "[" . $questionNumber . "]" . $sub . "[descripcion_1]";

    $text1 = '<div class="form-group">' . \Form::label($n, "Texto 1:", array("class" => "col-md-2 control-label")) . '<div class="col-sm-10">' . \Form::textarea($n, \Input::old($n),
            array("class" => "form-control ckeditor", "placeholder" => "Texto 1", $readyonly)) . '</div></div>';

    $n      = $name . "[" . $questionNumber . "]" . $sub . "[numero_pregunta]";
    $number = '<div class="form-group" >' . \Form::label($n, "N° Pregunta:", array("class" => "col-md-2 control-label")) . '<div class="col-sm-10" >' . \Form::text($n, $questionNumber + 1,
            array("class" => "form-control", "placeholder" => "Numero Pregunta", "readonly")) . '</div></div >';

    $categoryID     = \Form::hidden($name . "[" . $questionNumber . "]" . $sub . "[id_categoria]", $category, array("class" => "form-control"));
    $kindOfQuestion = \Form::hidden($name . "[" . $questionNumber . "]" . $sub . "[id_tipo_respuesta]", $kind, array("class" => "form-control"));

    if (!$isSubQuestion) {
        $out .= $number;
    }

    $out .= $text1;
    $out .= $categoryID;
    $out .= $kindOfQuestion;

    return $out;
});

/**
 * -------------------------------------
 * --         RESUMEN CUENTA          --
 * -------------------------------------
 */
\HTML::macro('resumenAccount', function ($data) {
    $client  = $data['cliente'];
    $plan    = $data['plan'];
    $sector  = $data['sector'];
    $users   = $data['usuarios'];
    $moments = $data['momentos'];
    $admin   = $data['admin'];

    // dd($moments);

    if (count($client)) {
        $template = \HTML::resumenCuentas($client, ['class' => 'col-md-4 col-sm-12 col-xs-12 item']);
    }
    if (count($sector)) {
        $template .= \HTML::resumenSectors($sector, ['class' => 'col-md-4 col-sm-12 col-xs-12 item']);
    }
    if (count($moments)) {
        $template .= \HTML::resumenMoments($moments, ['class' => 'col-md-4 col-sm-12 col-xs-12 item'], $client['id_cliente']);
    }
    if (count($admin)) {
        $template .= \HTML::resumenAdministrador($admin, ['class' => 'col-md-4 col-sm-12 col-xs-12 item']);
    }
    if (count($plan)) {
        $template .= \HTML::resumenPlans($plan, ['class' => 'col-md-4 col-sm-12 col-xs-12 item']);
    }
    if (count($users)) {
        $template .= \HTML::resumenUsuarios($users, ['class' => 'col-md-8 col-sm-12 col-xs-12 item']);
    }

    return $template;

});

\HTML::macro('templateResumenAccount', function ($title, $data, $attr = array()) {
    $attr = \HTML::attributes($attr);

    return '<div ' . $attr . '>
    <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">' . $title . '</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Min/Max"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remover"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">
                ' . $data . '
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>';
});

/**
 * @param       $moments
 * @param array $attr
 *
 * @return mixed
 */
\HTML::macro('resumenMoments', function ($moments, $attr = array(), $idCliente) {
    $out = '<table class="table table-hover table-condensed">
               <tbody>';

    $momentos = \MomentoEncuesta::whereIdCliente($idCliente)->get();
    $cant1    = count($momentos);
    $cant2    = count($moments);

    if ($cant1 != $cant2) {
        \Log::error('Resumen Cuenta ' . $idCliente . ' | Diferentes Cantidades Momentos');
    }

    $dir = public_path('temp/' . $idCliente . '/');
    if (!\File::exists($dir)) {
        // \File::makeDirectory($dir, (int)$mode = 777, (bool)$recursive = true, (bool)$force = true);
        if (!mkdir($dir, 0777, true)) {
            Log::error("Fallo al crear las carpetas... ($dir)");
            exit(1);
        }
    } else {
        if (!is_writable($dir)) {
            if (!chmod($dir, 0777)) {
                Log::error("Cannot change the mode of file ($dir)");
                exit;
            };
        }
    }

    foreach ($momentos as $momento) {
        $file = public_path('temp/' . $idCliente . '/' . $momento->id_momento . '.png');

        if (!\File::exists($file)) {
            //            \File::delete($file);

            $url = \Url::whereIdCliente($idCliente)->whereIdMomento($momento->id_momento)->first();

            if (!is_null($url)) {
                \ApiController::createQrCode($file, url($url->given));
            }
        }
    }

    foreach ($moments as $key => $value) {
        $out .= '<tr>';

        if (!is_null(array_get($value, 'url', null))) {
            $out .= '<td>' . $value['descripcion_momento'] . '<a href="' . array_get($value,
                    'url') . '" target="_blank" class="btn btn-link btn-xs pull-right">URL</a>';
            $out .= link_to_asset(asset('temp/' . $idCliente . '/' . ((int)$key + 1) . '.png'), 'QR', ['class' => 'btn btn-link btn-xs pull-right']) . '</td>';
        } else {
            $out .= '<td>' . $value['descripcion_momento'] . '</td>';
        }

        $out .= '</tr>';
    }

    $out .= '</tbody>
             </table>';

    return \HTML::templateResumenAccount('Momentos', $out, $attr);
});

/**
 * @param       $plan
 * @param array $attr
 */
\HTML::macro('resumenPlans', function ($plan, $attr = array()) {
    $out = '<table class="table table-condensed table-hover">';
    $out .= '<tr>';
    $out .= '<td><strong>Plan:</strong> <span class="pull-right">' . \Str::upper($plan['descripcion_plan']) . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Cantidad Encuestas:</strong> <span class="pull-right">' . $plan['cantidad_encuestas_plan'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Cantidad Momentos:</strong> <span class="pull-right">' . $plan['cantidad_momentos_plan'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Cantidad Usuarios:</strong> <span class="pull-right">' . $plan['cantidad_usuarios_plan'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Opt-In:</strong> <span class="pull-right">' . $plan['optin_plan'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Descarga Datos:</strong> <span class="pull-right">' . $plan['descarga_datos_plan'] . '</span></td>';
    $out .= '</tr>';
    $out .= '</table>';

    return \HTML::templateResumenAccount('Plan', $out, $attr);
});

/**
 * @param       $client
 * @param array $attr
 */
\HTML::macro('resumenCuentas', function ($client, $attr = array()) {
    $out = '<table class="table table-condensed table-hover">';
    $out .= '<tr>';
    $out .= '<td><strong>Nombre:</strong> <span class="pull-right">' . $client['nombre_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Nombre Legal:</strong> <span class="pull-right">' . $client['nombre_legal_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>RUT:</strong> <span class="pull-right">' . $client['rut_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>E-Mail:</strong> <span class="pull-right">' . $client['correo_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Fono fijo:</strong> <span class="pull-right">' . $client['fono_fijo_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Fono Celular:</strong> <span class="pull-right">' . $client['fono_celular_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Código Postal:</strong> <span class="pull-right">' . $client['codigo_postal_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Dirección:</strong> <span class="pull-right">' . $client['direccion_cliente'] . '</span></td>';
    $out .= '</tr>';
    $out .= '</table>';

    return \HTML::templateResumenAccount('Cuenta', $out, $attr);
});

/**
 * @param       $client
 * @param array $attr
 */
\HTML::macro('resumenSectors', function ($sector, $attr = array()) {
    $out = '<table class="table table-condensed table-hover">';
    $out .= '<tr>';
    $out .= '<td><strong>Rubro/Sector:</strong> <span class="pull-right">' . $sector['descripcion_sector'] . '</span></td>';
    $out .= '</tr>';
    $out .= '</table>';

    return \HTML::templateResumenAccount('Sector', $out, $attr);
});

/**
 * @param       $client
 * @param array $attr
 */
\HTML::macro('resumenUsuarios', function ($users, $attr = array()) {
    $out = '<table id="userTable" class="table table-hover table-condensed nowrap">
                <thead>
                <tr>
                    <th style="width: 20%">Nombre</th>
                    <th style="width: 80%">E-Mail</th>
                </tr>
                </thead>
                <tbody>';
    foreach ($users as $key => $value) {
        $out .= '<tr>';
        $out .= '<td>' . $value['nombre'] . '</td>';
        $out .= '<td>' . $value['email'] . '</td>';
        $out .= '</tr>';
    }
    $out .= '</tbody>
             </table>
             	<div class="clearfix"></div>';

    return \HTML::templateResumenAccount('Usuarios', $out, $attr);
});

/**
 * @param       $client
 * @param array $attr
 */
\HTML::macro('resumenAdministrador', function ($admin, $attr = array()) {
    $out = '<table class="table table-condensed table-hover">';
    $out .= '<tr>';
    $out .= '<td><strong>Nombre:</strong> <span class="pull-right">' . \Str::upper($admin['nombre']) . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Usuario:</strong> <span class="pull-right">' . $admin['usuario'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>E-Mail:</strong> <span class="pull-right">' . $admin['email'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Linked-In:</strong> <span class="pull-right">' . $admin['linkedlin'] . '</span></td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td><strong>Rol Organización:</strong> <span class="pull-right">' . $admin['rol_organizacion'] . '</span></td>';
    $out .= '</tr>';
    $out .= '</table>';

    return \HTML::templateResumenAccount('Administrador', $out, $attr);
});


/**
 * ==================================
 *      Reporte Ejecutivo - PDF
 * ==================================
 */
\HTML::macro('reportTable', function ($account, $type) {

    $report = new \ReporteController();
    $data   = $report->processReport($account, $type);

    return '<table class="table" id="' . $type . '">
				<thead>' . $data['header'] . '</thead>
				<tbody>' . $data['body'] . '</tbody>
            </table>';
});