<?php

namespace MajistiX\Tests\Editing;

require_once __DIR__ . '/TestHelper.php';

class AllTests extends \Majisti\Test\TestSuite
{
    public static function suite()
    {
        $suite = new self('MajistiX - Editing - All tests');

        $suite->addTestCase(__NAMESPACE__ . '\BootstrapTest');

        $suite->addTestSuite(Model\AllTests::suite());
        $suite->addTestSuite(Plugin\AllTests::suite());
        
        return $suite;
    }
}

AllTests::runAlone();
