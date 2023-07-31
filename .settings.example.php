<?php

return array(
    'utf_mode' =>
        array(
            'value' => true,
            'readonly' => true,
        ),
    'cache' =>
        array(
            'value' =>
                array(
                    'type' => 'memcache',
                    'memcache' => array(
                        'host' => 'memcached',
                        'port' => '11211',
                        'sid' => $_SERVER["DOCUMENT_ROOT"] . "#01"
                    ),
                ),
        ),
    'cache_flags' =>
        array(
            'value' =>
                array(
                    'config_options' => 3600.0,
                    'site_domain' => 3600.0,
                ),
            'readonly' => false,
        ),
    'cookies' =>
        array(
            'value' =>
                array(
                    'secure' => false,
                    'http_only' => true,
                ),
            'readonly' => false,
        ),
    'exception_handling' =>
        array(
            'value' =>
                array(
                    'debug' => true,
                    'handled_errors_types' => 4437,
                    'exception_errors_types' => 4437,
                    'ignore_silence' => false,
                    'assertion_throws_exception' => true,
                    'assertion_error_type' => 256,
                    'log' => NULL,
                ),
            'readonly' => false,
        ),
    'connections' =>
        array(
            'value' =>
                array(
                    'default' =>
                        array(
                            'className' => '\\Bitrix\\Main\\DB\\MysqliConnection',
                            'host' => 'db',
                            'database' => 'main_database',
                            'login' => 'main_user',
                            'password' => 'main_pass',
                            'options' => 2.0,
                        ),
                ),
            'readonly' => true,
        ),
    'crypto' =>
        array(
            'value' =>
                array(
                    'crypto_key' => '2465359af20cf5ad60b7ceb7d2c595a6',
                ),
            'readonly' => true,
        ),
    'composer' => [
        'value' => ['config_path' => $_SERVER['DOCUMENT_ROOT'] . '/local/composer.json']
    ],
);
