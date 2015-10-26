<div class="form-group">
	{{ Form::label('id_plan', 'Plan:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::bsRadioForm('cliente[id_plan]', $plans, Input::old('id_plan'), array('class'=>'form-control')) }}
	</div>
</div>