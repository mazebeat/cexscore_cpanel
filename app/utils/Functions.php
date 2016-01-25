<?php namespace App\Util;

Class Functions
{
    /**
     * @param        $array
     * @param string $prefix
     *
     * @return array
     */
    public static function array_flatten($array, $prefix = '')
    {
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = $result + self::array_flatten($value, $prefix . $key . '.');
            } else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param $string
     *
     * @return string
     */
    public static function e2($string)
    {
        return utf8_encode(html_entity_decode($string));
    }

    /**
     * @param $data
     *
     * @return string
     */
    public static function printr($data)
    {
        return "<pre>" . htmlspecialchars(print_r($data, true)) . "</pre>";
    }

    /**
     * @param $class
     *
     * @return \ReflectionMethod[]
     */
    public static function getMethods($class)
    {
        $class   = new \ReflectionClass($class);
        $methods = $class->getMethods();

        return $methods;
    }

    /**
     * @return mixed
     */
    public static function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);

        return array_pop($args);
    }

    /**
     * @param        $array_in
     * @param string $version
     * @param string $encoding
     *
     * @return string
     */
    public static function toXML($array_in, $version = '1.0', $encoding = 'ISO-8859-1')
    {
        if (!array_key_exists('cabecera', $array_in)) {
            return 'No se encontro $key: Cabecera';
        }

        if (!array_key_exists('detalle', $array_in)) {
            return 'No se encontro $key: Detalle';
        }

        $array = '<?xml version="' . $version . '" encoding="' . $encoding . '" ?>' . PHP_EOL;
        $array .= '<Documento>' . PHP_EOL;
        $array .= '<Cabecera>' . PHP_EOL;
        $array .= self::arrayToXML($array_in['cabecera']);
        $array .= '</Cabecera>' . PHP_EOL;

        foreach ($array_in['detalle'] as $key => $value) {
            $array .= '<Detalle>' . PHP_EOL;
            $array .= self::arrayToXML($value);
            $array .= '</Detalle>' . PHP_EOL;
        }

        $array .= '</Documento>' . PHP_EOL;

        $array = str_replace(PHP_EOL, '', $array/**/);

        return $array;
    }

    /**
     * @param        $array_in
     * @param string $version
     * @param string $encoding
     *
     * @return string
     */
    public static function arrayToXML($array_in, $version = '1.0', $encoding = 'ISO-8859-1')
    {
        $return     = '';
        $attributes = array();
        foreach ($array_in as $k => $v) {
            if ($k[0] == "@") {
                $attributes[str_replace("@", "", $k)] = $v;
            } else {
                if (is_array($v)) {
                    $return .= self::generateXML($k, self::arrayToXML($v), $attributes) . PHP_EOL;
                    $attributes = array();
                } else {
                    if (is_bool($v)) {
                        $return .= self::generateXML($k, (($v == true) ? "true" : "false"), $attributes) . PHP_EOL;
                        $attributes = array();
                    } else {
                        $return .= self::generateXML($k, $v, $attributes) . PHP_EOL;
                        $attributes = array();
                    }
                }
            }
        }

        return $return;
    }

    /**
     * @param        $tag_in
     * @param string $value_in
     * @param string $attribute_in
     *
     * @return string
     */
    public static function generateXML($tag_in, $value_in = "", $attribute_in = "")
    {
        $attributes_out = "";
        if (is_array($attribute_in)) {
            if (count($attribute_in) != 0) {
                foreach ($attribute_in as $k => $v):
                    $attributes_out .= " " . $k . "=\"" . $v . "\"";
                endforeach;
            }
        }

        return "<" . $tag_in . "" . $attributes_out . ((trim($value_in) == "") ? "/>" : ">" . $value_in . "</" . $tag_in . ">");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public static function base64urlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * @param $data
     *
     * @return string
     */
    public static function base64urlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    /**
     * @param $object
     *
     * @return mixed
     */
    public static function objectToArray($object)
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * @param $array
     *
     * @return mixed
     */
    public static function arrayToObject($array)
    {
        return json_decode(json_encode($array), false);
    }

    /**
     * @param $array
     *
     * @return \stdClass
     */
    public static function toObject($array)
    {
        $obj = new \stdClass();
        foreach ($array as $key => $val) {
            $key       = strtolower(trim($key));
            $obj->$key = is_array($val) ? self::toObject($val) : $val;
            //			$obj->$key = $val;
        }

        return $obj;
    }

    /**
     * @param $array
     * @param $limit
     *
     * @return int
     */
    public static function count_recursive($array, $limit)
    {
        $count = 0;
        foreach ($array as $id => $_array) {
            if (is_array($_array) && $limit > 0) {
                $count += self::count_recursive($_array, $limit - 1);
            } else {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * @return mixed|string
     */
    public static function getRealIP()
    {
        if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : ((!empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : "unknown");

            $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

            reset($entries);
            while (list(, $entry) = each($entries)) {
                $entry = trim($entry);
                if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)) {
                    // http://www.faqs.org/rfcs/rfc1918.html
                    $private_ip = array(
                        '/^0\./',
                        '/^127\.0\.0\.1/',
                        '/^192\.168\..*/',
                        '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                        '/^10\..*/',
                    );

                    $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

                    if ($client_ip != $found_ip) {
                        $client_ip = $found_ip;
                        break;
                    }
                }
            }
        } else {
            $client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : ((!empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : "unknown");
        }

        return $client_ip;

    }

    /**
     * @return mixed
     */
    public static function serverData()
    {
        $data['IP'] = $_SERVER['REMOTE_ADDR'];
        if (preg_match('/' . "Netscape" . '/', $_SERVER["HTTP_USER_AGENT"])) {
            $data['BROWSER'] = "Netscape";
        } elseif (preg_match('/' . "Firefox" . '/', $_SERVER["HTTP_USER_AGENT"])) {
            $data['BROWSER'] = "FireFox";
        } elseif (preg_match('/' . "MSIE" . '/', $_SERVER["HTTP_USER_AGENT"])) {
            $data['BROWSER'] = "MSIE";
        } elseif (preg_match('/' . "Opera" . '/', $_SERVER["HTTP_USER_AGENT"])) {
            $data['BROWSER'] = "Opera";
        } elseif (preg_match('/' . "Konqueror" . '/', $_SERVER["HTTP_USER_AGENT"])) {
            $data['BROWSER'] = "Konqueror";
        } elseif (preg_match('/' . "Chrome" . '/', $_SERVER["HTTP_USER_AGENT"])) {
            $data['BROWSER'] = "Chrome";
        } elseif (preg_match('/' . "Safari" . '/', $_SERVER["HTTP_USER_AGENT"])) {
            $data['BROWSER'] = "Safari";
        } else {
            $data['BROWSER'] = "UNKNOWN";
        }

        return $data;
    }

    /**
     * @param $number
     *
     * @return array|mixed|string
     */
    public static function convNumberToMonth($number)
    {
        $month = array(
            1  => 'enero',
            2  => 'febrero',
            3  => 'marzo',
            4  => 'abril',
            5  => 'mayo',
            6  => 'junio',
            7  => 'julio',
            8  => 'agosto',
            9  => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre',
        );
        $month = array_get($month, $number);
        $month = studly_case($month);

        return $month;
    }

    /**
     * @param null   $url
     * @param null   $postFields
     * @param string $requestType
     *
     * @return mixed|string
     */
    public static function curlRequest($url = null, $postFields = null, $requestType = 'GET')
    {
        if (!isset($url)) {
            return json_encode(array('error' => 'URL param is required'));
        }
        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, $url);
        if ($requestType == 'POST') {
            curl_setopt($client, CURLOPT_POST, true);
            curl_setopt($client, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($postFields)); //
        } else {
            curl_setopt($client, CURLOPT_POST, false);
        }
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($client);
        $result   = json_decode($response);
        curl_close($client);

        return $result;
    }

    /**
     * @param $arr
     * @param $root
     *
     * @return mixed
     */
    function array2XML($arr, $root)
    {
        $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><{$root}></{$root}>");
        $f   = create_function('$f,$c,$a', '
        foreach($a as $v) {
            if(isset($v["@text"])) {
                $ch = $c->addChild($v["@tag"],$v["@text"]);
            } else {
                $ch = $c->addChild($v["@tag"]);
                if(isset($v["@items"])) {
                    $f($f,$ch,$v["@items"]);
                }
            }
            if(isset($v["@attr"])) {
                foreach($v["@attr"] as $attr => $val) {
                    $ch->addAttribute($attr,$val);
                }
            }
        }');
        $f($f, $xml, $arr);

        return $xml->asXML();
    }

    public static function ucfirst($str)
    {
        $str = mb_strtolower($str);
        $words = preg_split('/\b/u', $str, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($words as $word) {
            $ucword = mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
            $str = str_replace($word, $ucword, $str);
        }
        return $str;
    }
}