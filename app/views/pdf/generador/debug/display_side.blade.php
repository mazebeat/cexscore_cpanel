<div class="container">
    <div class="row text-center" style="margin-bottom:40px;margin-top:20px;">
        <div class="col-xs-12" style="padding-bottom: 20px;">
            {{--<img src="{{url($apariencia['logo_header'])}}" alt="Logo" style="max-height: 150px;">--}}
            <img src="{{public_path($apariencia['logo_header'])}}" alt="Logo" style="max-height: 150px;">
        </div>
        <br />
        <br />
        <div class="col-xs-12">
            <h3 style="font-size: 30px;">
                <strong>
                    CONOCER TU EXPERIENCIA ES <br />
                    PARTE DE NUESTRO NEGOCIO
                </strong>
            </h3>
        </div>
    </div>

    <div class="row text-center" style="margin-bottom:30px;">
        <div class="col-xs-12">
            <strong style="font-size: 24px;">
                Ingresa con tu celular al código QR<br />
                o a la página
            </strong>
            <br />
            <a href="{{url($url['given'])}}" style="font-size:34px;">{{url($url['given'])}}</a>
            <br />
            <strong style="font-size: 24px;">y contesta nuestras 4 preguntas</strong>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 text-center">
            {{--<img src="{{url($URLrutaQR)}}" alt="Codigo QR" class="img-responsive" style="">--}}
            <img src="{{public_path($URLrutaQR)}}" alt="Codigo QR" class="img-responsive" style="">
        </div>
    </div>

    <div class="row">
        {{$footer or ''}}
    </div>
</div>
