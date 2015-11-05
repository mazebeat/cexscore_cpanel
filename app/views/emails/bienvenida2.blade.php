<!DOCTYPE html>
<html lang="es-CL">
<head>
	<meta charset="utf-8">
</head>
<body style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
<h2>Hola {{{ $nombre_usuario }}}!</h2>

<div style="text-align: justify;">
	<p>Le damos la bienvenida a CustomerExperience SCORE!</p>

	<p>Desde ahora usted puede tomar el pulso a la experiencia del cliente para aumentar la fidelización y recomendación de su marca.</p>

	<p>Los enlaces cortos y QR provistos permitirán que usted despliegue en su negocio espacios para que sus clientes opinen sobre la calidad del servicio y la experiencia. Recomendamos que aplique estos elementos como adhesivos en lugares visibles y en los “momentos claves” de su negocio, agregando algún beneficio o descuento para fomentar la respuesta.</p>

	<p>Con el usuario y contraseña que está recibiendo, usted podrá acceder al panel de visualización de respuestas para contar con una vista de la experiencia de sus clientes desde su teléfono móvil, tablet o cualquier computador de escritorio.</p>

	<ul>
		<li><strong>Usuario:</strong>&nbsp; {{{ $usuario }}}</li>
		<li><strong>Contraseña:</strong>&nbsp;"123456"</li>
		<li><strong>Enlaces:</strong>&nbsp;</li>
		<ul>
			@foreach($urls as $url)
				<li><strong>{{{ $url['descripcion_momento'] }}}:</strong>&nbsp;<a href="http://{{ $url['url'] }}" target="_blank">{{{ $url['url'] }}}</a></li>
			@endforeach
		</ul>
		</li>
	</ul>

	<p>¡Y lo más importante! No olvide enrolar al equipo de personas que trabaje con usted, para que participen activamente en el proceso de escuchar a los clientes.</p>

	<p>Si tiene dudas de la aplicación de estos elementos puede conectarse con nosotros en <a href="mailto:ayuda@customertrigger.com">ayuda@customertrigger.com</a> o en
		<a href="http://www.customertrigger.com">www.CustomerTrigger.com</a></p>

	<p>Saludos, El Equipo CustomerTrigger</p>

	<br>

	<p>
		<strong>Notificación</strong>
		<br> Al registrarse y acceder a su cuenta usted declara estar de acuerdo con los Términos y Condiciones de la herramienta ofrecida. Sírvase leer cuidadosamente los Términos y Condiciones presentes en los enlaces abajo.
	</p>    <br>
</div>
<footer class="container">
	<section class="row">
		<article class="">
			<p class="" style="text-align:center;">
			<address class="" style="text-align:center;">

				<a href="http://www.customertrigger.com/termino-de-uso-politicas-de-privacidad-customerexperience-score/" target="_blank">T&eacute;rminos de Uso</a> |
				<a href="http://www.customertrigger.com/termino-de-uso-politicas-de-privacidad-customerexperience-score/" target="_blank">Pol&iacute;tica de Privacidad</a> |
				<a href="http://www.customertrigger.com/customer-experience-score/" target="_blank">Nuestra Soluci&oacute;n</a> |
				<a href="http://www.customertrigger.com/registro-zona-de-recursos/" target="_blank">Zona de Recursos</a><br> <b>Desarrollado por &copy;
					<a href="http://www.customertrigger.com/">Customer Trigger S.A.</a> {{ Carbon::now()->year == '2015' ? Carbon::now()->year : '2015-' . Carbon::now()->year }} <br>
				</b> Direcci&oacute;n Comercial: Fanor Velasco No.85, Piso 9, Santiago | Direcci&oacute;n Legal: Sotero Del R&iacute;o 508, Oficina 826, Santiago <br>
				<abbr title="Tel&eacute;fono">T:</abbr> <a href="tel:+56222198993">+562 22 198 993</a> | <a href="http://customertrigger.com/" target="_blank">http://www.customertrigger.com</a> |
				<a href="mailto:ayuda@customertrigger.com">ayuda@customertrigger.com</a>
			</address>
			</p>
		</article>
	</section>
</footer>
</body>
</html>
