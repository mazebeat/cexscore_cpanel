<?php

switch (PHP_INT_SIZE) {
    case 4:
        // echo '32-bit version of PHP';
        $bits = 32;
        break;
    case 8:
        // echo '64-bit version of PHP';
        $bits = 32;
        break;
}

$win32  = array(
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
$win64  = array(
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
$unix32 = array(
    'pdf'   => array(
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386'),
        'timeout' => false,
        'options' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltoimage-i386/bin/wkhtmltoimage-i386'),
        'timeout' => false,
        'options' => array(),
    ),
);
$unix64 = array(
    'pdf'   => array(
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'),
        'timeout' => false,
        'options' => array(),
    ),
);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    if ($bits == 64) {
        return $win64;
    }

    return $win32;
} else {
    if ($bits == 64) {
        return $unix64;
    }

    return $unix32;
}