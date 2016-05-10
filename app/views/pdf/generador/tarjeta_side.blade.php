<div class="">
    <div class="row text-center">
        {{--<img src="{{url($apariencia['logo_header'])}}" alt="Logo" style="max-height: 90px;margin-bottom: 10px;">--}}
        <img src="{{public_path($apariencia['logo_header'])}}" alt="Logo" style="max-height: 72px;margin-bottom: 5px;">
        <h5>
            CONOCER TU EXPERIENCIA ES<br />
            PARTE DE NUESTRO NEGOCIO
        </h5>
    </div>

    <div class="row text-center">
        <span style="font-size: 12px;">Ingresa con tu celular al código QR<br /> o a la página</span>
        <br />
        <a href="{{url($url['given'])}}" style="font-size:12pt;">{{url($url['given'])}}</a>
        <br />
        <span style="font-size: 12px;">y contesta nuestra encuesta de 4 preguntas</span>
    </div>
    <div class="row" style="">

        <div class="col-xs-12 text-center">
            {{--<img src="{{url($URLrutaQR)}}" alt="Codigo QR" style="width: 140px;">--}}
            <img src="{{public_path($URLrutaQR)}}" alt="Codigo QR" style="width: 80px;">
        </div>
    </div>
    <div class="row">
        {{$footer}}
    </div>
</div>
