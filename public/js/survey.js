/**
 * Created by Maze on 10-07-2015.
 */

var input_color = 'blue';

switch (color) {
    case 'rojo':
        input_color = 'red';
        break;
    case 'verde':
        input_color = 'green';
        break;
    case 'azul':
        input_color = 'blue';
        break;
    case 'gris':
        input_color = 'grey';
        break;
    case 'naranjo':
        input_color = 'orange';
        break;
    case 'amarillo':
        input_color = 'yellow';
        break;
    case 'rosado':
        input_color = 'pink';
        break;
    case 'morado':
        input_color = 'purple';
        break;
    default:
        input_color = 'blue';
        break;
}

//console.log('iradio_square-' + input_color);
jq('input[type=radio]').iCheck({
    radioClass: 'iradio_square-' + input_color,
    increaseArea: '20%',
    labelHover: true,
    cursor: true
}).on('ifChecked', function (event) {
    event.preventDefault();
    var $name = jq(this).attr('name');
    var $value = jq(this).val();
    jq('select[name="' + $name + '"]').select2('val', $value);
    jq('#surveyForm').formValidation('revalidateField', $name);
});

jq('input[type=checkbox]').iCheck({
    checkboxClass: 'icheckbox_square-' + input_color,
    increaseArea: '20%',
    labelHover: true,
    cursor: true
});

jq('select').select2({
    width: '100%',
    containerCssClass: '',
    dropdownAutoWidth: true,
    dropdownCssClass: 'text-center'
}).change(function (event) {
    event.preventDefault();
    var $name = jq(this).attr('name');
    var $value = event.val;
    jq('input[type=radio][name="' + $name + '"][value=' + $value++ + ']').iCheck('toggle');
    jq('#surveyForm').formValidation('revalidateField', $name);
});

jq('#gender').select2().change(function (e) {
    $('#gender').formValidation('revalidateField', 'gender');
});

jq('.table td').hover(function () {
        jq(this).find('.iradio_square-' + input_color).addClass('hover');
    }, function () {
        jq(this).find('.iradio_square-' + input_color).removeClass("hover");
    }
).click(function (event) {
        event.preventDefault();
        jq(this).find('.iradio_square-' + input_color).iCheck('toggle');
    });


jq('input[type=submit]').darkcolor();

/**
 *  Bootstrap Validator
 */
jq('#surveyForm').formValidation({
    err: {
        clazz: 'help-block2',
        container: function ($field, validator) {
            return $field.parents('.form-group').next('.messageContainer');
        }
    }
}).on('success.form.fv', function (e) {
}).on('err.field.fv', function (e, data) {
});

