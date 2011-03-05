<?php

namespace MajistiX\Tests\Editing;

require_once dirname(__DIR__) . '/demo/bootstrap.php';

$helper = \Majisti\Test\Helper::getInstance();
$helper->setOptions($appLoader->getOptions());
$helper->init();
$helper->addExtension(
    'majisti-extension-editing-srosato',
    __NAMESPACE__,
    __DIR__
);

unset($helper, $appLoader);
