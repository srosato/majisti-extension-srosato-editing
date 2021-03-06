<?php

$settings = array('majisti' => array(
        'app' => array(
            'namespace' => 'MajistiT',
            'env'       => 'development',
            'path'      => __DIR__,
        ),
        'lib'       => array(
            'majisti' => 'majisti-0.4/lib',
            'app'     => null
        ),
    ),
    'resources' => array(
        'db' => array(
            'params' => array(
                'dbname' => 'majisti_test',
                'username' => 'root',
                'password' => '',
                'host'    => 'localhost',
            ),
            'adapter' => 'pdo_mysql',
            'isDefaultTableAdapter' => true,
        ),
        'extensions' => array('paths' => array(
            array(
                'namespace' => 'MajistiX',
                'path'      => dirname(dirname(__DIR__))
            )
        )),
    ),
);

require_once __DIR__ . '/application/Loader.php';
$appLoader = new \Majisti\Application\Loader($settings);

unset($settings);
