<?php

namespace MajistiX\Tests\Editing;

/* fallsback to parent test helper */
require_once dirname(__DIR__) . '/../tests/TestHelper.php';

$helper = \Majisti\Test\Helper::getInstance();
$helper->addExtension(
    basename(dirname(dirname(__DIR__))),
    __NAMESPACE__,
    __DIR__
);