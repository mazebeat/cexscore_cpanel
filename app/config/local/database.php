<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */
    
    'default' => 'mysql',

    'connections' => array(

        'mysql_qa' => array(
            'driver'    => 'mysql',
            'host'      => '192.168.1.103',
            'database'  => 'panel_exscore',
            'username'  => 'root',
            'password'  => 'inteladmin',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        'mysql_prod' => array(
            'driver'    => 'mysql',
            'host'      => '192.168.1.52',
            'database'  => 'panel_exscore',
            'username'  => 'root',
            'password'  => 'inteladmin',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        'mysql_dv' => array(
            'driver'    => 'mysql',
            'host'      => '192.168.1.30',
            'database'  => 'panel_exscore',
            'username'  => 'root',
            'password'  => 'intelimysql',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'panel_exscore',
            'username'  => 'root',
            'password'  => 'mz.120712',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        'pgsql' => array(
            'driver'   => 'pgsql',
            'host'     => 'localhost',
            'database' => 'homestead',
            'username' => 'homestead',
            'password' => 'secret',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ),

        'project' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'project',
            'username'  => 'root',
            'password'  => 'mz.120712',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

    ),

);
