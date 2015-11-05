<?php

/**
 * Url
 *
 * @property integer $id 
 * @property string $given 
 * @property string $url 
 * @property string $params 
 * @property integer $id_canal 
 * @property integer $id_momento 
 * @property integer $id_cliente 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \MomentoEncuesta $momento 
 * @method static \Illuminate\Database\Query\Builder|\Url whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereGiven($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereParams($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereIdCanal($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereIdMomento($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereIdCliente($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Url whereUpdatedAt($value)
 */
class Url extends Eloquent
{
    public static $rules    = array('url' => 'required|url');
    protected     $table    = 'urls';
    protected     $fillable = [
        'id',
        'given',
        'url',
        'params',
        'id_canal',
        'id_momento',
        'id_cliente',
    ];

    public static function validate($input)
    {
        $v = Validator::make($input, static::$rules);

        return $v->fails() ? $v : true;
    }

    public static function getShortenedUrl()
    {
        $shortened = base_convert(rand(10000, 999999), 10, 36);
        if (static::whereGiven($shortened)->first()) {
            return static::getShortenedUrl();
        }

        return $shortened;
    }

    public function momento()
    {
        return $this->belongsTo('MomentoEncuesta', 'id_momento');
    }
}