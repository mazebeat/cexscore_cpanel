<script type="text/javascript"></script>
<style type="text/css" media="all">
	header {
		background-color: {{ $theme->color_header }};
		color: {{ $theme->color_text_header }};

	}

	.header_text {
		color: {{ $theme->color_text_header }};
	}

	h2 small {
		color: {{ $theme->color_text_header }};
		font-weight: normal;
	}

	body {
		background-color: {{ $theme->color_body }};
	}

	main.backend {
		margin-top: 10px;
	}

	#surveyForm input[type=submit], input[type=button], .btn {
		@if(isset($theme->color_boton) && $theme->color_boton != '')
			  background-color: {{ $theme->color_boton  }};
		@else
			  background-color: {{ $theme->color_text_header  }};
		@endif
	}

	.survey_text {
		color: {{ $theme->color_text_body }};
	}

	.instrucciones {
		color: {{ $theme->color_instrucciones }};
	}

	.btn-primary, .label-primary, .alert-info {
		background-color: {{ $theme->color_body }};
	}

	footer {
		background-color: {{ $theme->color_footer }};
		color: {{ $theme->color_text_footer }};
	}

	footer.text_footer {
		background-color: {{ $theme->color_body }};
		color: {{ $theme->color_text_body }};
	}

	/*.user img {*/
		/*-webkit-filter: drop-shadow(4px 4px 3px rgba(0, 0, 0, 0.1));*/
		/*filter: drop-shadow(4px 4px 3px rgba(0, 0, 0, 0.1));*/
	/*}*/
</style>