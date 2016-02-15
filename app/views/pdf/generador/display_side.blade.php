<div class="container">
    <div class="row text-center" style="margin-bottom:20px;margin-top:20px;">
        <div class="col-xs-12">
            <img src="{{public_path($apariencia['logo_header'])}}" alt="Logo" style="max-height: 150px;">
        </div>
        <div class="col-xs-12">
            <h3>
                CONOCER TU EXPERIENCIA ES PARTE DE NUESTRO NEGOCIO
            </h3>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-xs-12">
            <span style="font-size: 20px;">Ingresa con tu celular al código QR o a la página</span><br />

            <a href="{{url($url['given'])}}" style="font-size:22px;">{{url($url['given'])}}</a> <br />

            <span style="font-size: 20px;">y contesta nuestra encuesta de 4 preguntas</span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 text-center">
            <img src="{{public_path($URLrutaQR)}}" alt="Codigo QR" class="img-responsive" style="">
        </div>
    </div>
    <div class="row">
        {{$footer or ''}}
    </div>

</div>
