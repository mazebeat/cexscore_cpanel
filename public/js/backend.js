var jq = jQuery.noConflict();

//jq('#loginForm').formValidation({
//    fields: {
//        rut: {
//            message: 'El RUT no es valido',
//            validators: {
//                notEmpty: {
//                    message: 'El campo RUT es requerido'
//                },
//                callback: {
//                    callback: function (value, validator) {
//                        return jq.validateRut(value);
//                    },
//                    message: 'El campo RUT es incorrecto'
//                },
//                stringLength: {
//                    min: 8,
//                    max: 9,
//                    message: 'El campo RUT debe tener entre 8 y 9 caracteres'
//                }
//            }
//        }
//    }
//});


jq('#loginForm').formValidation();