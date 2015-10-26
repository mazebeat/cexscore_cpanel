<?php

/**
 * Apariencia
 *
 * @property integer $id_apariencia 
 * @property string $logo_header 
 * @property string $logo_incentivo 
 * @property string $color_header 
 * @property string $color_body 
 * @property string $color_footer 
 * @property string $color_boton 
 * @property string $color_opciones 
 * @property string $color_text_header 
 * @property string $color_text_body 
 * @property string $color_text_footer 
 * @property string $color_instrucciones 
 * @property boolean $desea_captura_datos 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cliente[] $clientes 
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereIdApariencia($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereLogoHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereLogoIncentivo($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorBody($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorFooter($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorBoton($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorOpciones($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorTextHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorTextBody($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorTextFooter($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereColorInstrucciones($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereDeseaCapturaDatos($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Apariencia whereUpdatedAt($value)
 */
class Apariencia extends \Eloquent
{
    public static $rules      = array(
        'id_apariencia'       => 'required',
        'logo_header'         => 'required',
        'logo_incentivo'      => 'required',
        'color_header'        => 'required',
        'color_body'          => 'required',
        'color_footer'        => 'required',
        'color_boton'         => 'required',
        'color_opciones'      => 'required',
        'color_text_header'   => 'required',
        'color_text_body'     => 'required',
        'color_text_footer'   => 'required',
        'color_instrucciones' => 'required',
        'desea_captura_datos' => 'required',
    );
    protected     $table      = 'apariencia';
    protected     $primaryKey = 'id_apariencia';
    protected     $fillable   = [
        'logo_header',
        'logo_incentivo',
        'color_header',
        'color_body',
        'color_footer',
        'color_boton',
        'color_opciones',
        'color_text_header',
        'color_text_body',
        'color_text_footer',
        'color_instrucciones',
        'desea_captura_datos',
    ];

    public function clientes()
    {
        return $this->belongsToMany('Cliente', 'cliente_apariencia', 'id_apariencia', 'id_cliente');
    }

    public function deseaCaptura()
    {
        if ($this->attributes['desea_captura_datos'] == 1) {
            return true;
        }

        return false;
    }

}