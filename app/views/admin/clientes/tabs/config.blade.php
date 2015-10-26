<div class="form-group">
	{{ Form::label('id_plan', 'Plan:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::bsRadioForm('cliente[id_plan]', $plans, Input::old('id_plan', 1), array('class'=>'form-control
		')) }}
	</div>
</div>

<div class="form-group cant_moment_plan">
	{{ Form::label('id_plan', 'Cantidad Momentos:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-8">
		{{ Form::number('cant_moment_plan', Input::old('cant_moment_plan'), null, ['id' => 'cant_moment_plan', 'class'=>'form-control',  'data-fv-integer' =>"true",
		'data-fv-greaterthan' => 'true', 'data-fv-greaterthan-value' => 1, 'data-fv-lessthan' => 'true', 'data-fv-lessthan-value' => 999,
		'disabled', 'required']) }}
	</div>
	<div class="col-sm-2">
		<input type="button" class="btn btn-info" value="Agregar" id="addMoments" disabled/>
	</div>
</div>

<!-- The template for adding new field -->
<div class="form-group hide" id="optionTemplate">
	<label class="col-md-2 control-label" for="id_plan">Momento </label>

	<div class="col-sm-8">
		<input type="text" name="momento_encuesta[]" value="" class="form-control"/>
	</div>
</div>