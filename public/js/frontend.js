var jq = jQuery.noConflict();

jq(document).ready(function () {
    jq(window).scroll(function () {
        if (jq(this).scrollTop() > 350) {
            jq('#go-top').fadeIn(350);
        } else {
            jq('#go-top').fadeOut(350);
        }
    });

    jq('#go-top').click(function (event) {
        event.preventDefault();
        jq('html, body').animate({
            scrollTop: 0
        }, 800);
    }).tooltip('show');

    jq('#btn_neg').click(function (event) {
        event.preventDefault();
        jq('.politicas').remove();
        var div = jq(this).parents('div.alert');
        div.find('h4').remove();
        div.find('p').remove();
        div.append('<p><i class="fa fa-check fa-fw"></i>Gracias por tu tiempo, ¡Tu opinión es muy importante!</p>');
        div.removeClass('alert-warning').addClass('alert-success');
        // MODIFICAR EL METODO DE LOGOUT
        jq.get("logout", function (jqmessage) {
            console.log(jqmessage);
            if (jqmessage == 'OK') {
                //setTimeout('window.location.href=\"http://www.umayor.cl/\";', 5000);
            }
        });
    });

    jq('#modal1_ok').click(function (event) {
        event.preventDefault();
        jq("#modal1").modal('toggle');
        // MODICAR METODO DEL MODAL
        jq.get("addexception", function (jqmessage) {
            console.log(jqmessage);
            if (jqmessage === 'OK') {
                //    setTimeout('window.location.href=\"http://www.umayor.cl/\";', 5000);
            }
        });
    });
});

jq("textarea").keyup(function () {
    jq(this).parent().find('small.count').text('Caracteres: ' + jq(this).val().length);
});

jq.extend({
    oscurecerColor: function (color, cant) {
        if (jq.trim(color) != '') {
            var rojo = color.substr(1, 2);
            var verd = color.substr(3, 2);
            var azul = color.substr(5, 2);

            var introjo = parseInt(rojo, 16);
            var intverd = parseInt(verd, 16);
            var intazul = parseInt(azul, 16);

            if (introjo - cant >= 0) introjo = introjo - cant;
            if (intverd - cant >= 0) intverd = intverd - cant;
            if (intazul - cant >= 0) intazul = intazul - cant;

            rojo = introjo.toString(16);
            verd = intverd.toString(16);
            azul = intazul.toString(16);

            if (rojo.length < 2) rojo = "0" + rojo;
            if (verd.length < 2) verd = "0" + verd;
            if (azul.length < 2) azul = "0" + azul;

            return "#" + rojo + verd + azul;
        }

        console.error('Error in "oscurecerColor" function.');
    },
    hex: function (x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
});

jq.fn.extend({
    darkcolor: function () {
        var bgcolor = jq(this).css('background-color');
        var bordercolor = jq.oscurecerColor(bgcolor, 30);
        jq(this).css("border-bottom", '3px solid ' + bordercolor);
    },
    zigzag: function () {
        var text = $(this).text();
        var zigzagText = '';
        var toggle = true; //lower/uppper toggle
        jq.each(text, function (i, nome) {
            zigzagText += (toggle) ? nome.toUpperCase() : nome.toLowerCase();
            toggle = (toggle) ? false : true;
        });
        return zigzagText;
    }
});

jq.cssHooks.backgroundColor = {
    get: function (elem) {
        var bg;
        if (elem.currentStyle)
            bg = elem.currentStyle["backgroundColor"];
        else if (window.getComputedStyle)
            bg = document.defaultView.getComputedStyle(elem, null).getPropertyValue("background-color");
        if (bg.search("rgb") == -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

            return "#" + jq.hex(bg[1]) + jq.hex(bg[2]) + jq.hex(bg[3]);
        }
    }
};

