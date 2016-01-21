<?php

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    return array(
        'pdf'   => array(
            'enabled' => true,
            'binary'  => base_path('vendor/wemersonjanuario/wkhtmltopdf-windows/bin/32bit/wkhtmltopdf.exe'),
            'timeout' => false,
            'options' => array(),
        ),
        'image' => array(
            'enabled' => true,
            'binary'  => '/usr/local/bin/wkhtmltoimage',
            'timeout' => false,
            'options' => array(),
        ),
    );

} else {
    return array(
        'pdf'   => array(
            'enabled' => true,
            'binary'  => base_path('vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386'),
            'timeout' => false,
            'options' => array(),
        ),
        'image' => array(
            'enabled' => true,
            'binary'  => '/usr/local/bin/wkhtmltoimage',
            'timeout' => false,
            'options' => array(),
        ),
    );

}

