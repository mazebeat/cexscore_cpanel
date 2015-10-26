<?php

/*
 | ------------------------------------------------------
 | Api Configurator
 | ------------------------------------------------------
 | Use this file to declare all api values to call later
 |
 */
return [// ApiKey
        'apiKey'    => 'panelCustomerExperienceScore2015',
        // MCrypt Class
        'mcrypt'    => [
            'key' => 'panelCExScore',
            'iv'  => 'cu2t0m3rtr1gg3r',
        ],
        // Landing Setup
        'title'     => 'Panel Customer Experience Score',
        'profiles'  => [
            'administrator' => 'ADM',
            'public'        => 'PUB',
        ],
        'company'   => [
            'name' => 'CustomerTrigger',
            'url'  => 'http://www.customertrigger.com/'
        ],
        'demo'      => false,
        'curlError' => false,
        // Text Global
        'text'      => []
];