<?php

namespace MajistiX\Tests\Editing;

use MajistiX\Editing\Bootstrap;

require_once __DIR__ . '/TestHelper.php';

/**
 * @desc Tests the InPlaceEditing extension bootstrap.
 *
 * @author Majisti
 */
class BootstrapTest extends \Majisti\Test\TestCase
{
    /**
     * @var MajistiX\Extension\InPlaceEditing\Bootstrap
     */
    public $bootstrap;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @desc Setups the test case.
     */
    public function setUp()
    {
        $bootstrap = $this->getHelper()->createBootstrapInstance()
            ->bootstrap();

        /* retrieve entity manager */
        $this->em = $bootstrap->getPluginResource('Doctrine')->getEntityManager();
        $this->bootstrap = new Bootstrap($bootstrap->getApplication());
    }

    /**
     * @desc Tests that loading the bootstrap will ensure
     * that a static PHP driver for the extension's models is used
     */
    public function testBootstrapEnsuresStaticDriverUsage()
    {
        $em = $this->em;
        $this->bootstrap->bootstrap();

        /* @var $driverChain \Doctrine\ORM\Mapping\Driver\DriverChain */
        $driverChain = $em->getConfiguration()->getMetadataDriverImpl();
        $drivers = $driverChain->getDrivers();
        $namespace = $this->getNamespace() . '\Model';

        /* ensure driver is contained in the driver chain */
        $this->assertArrayHasKey($namespace, $drivers);
        $this->assertThat($drivers[$namespace], $this->isInstanceOf(
            'Doctrine\ORM\Mapping\Driver\StaticPHPDriver'));
    }

    /**
     * @desc Tests that all controller plugins are added correctly
     * to the front controller.
     */
    public function testBootstrapEnsuresPluginsLoaded()
    {
        $this->bootstrap->bootstrap();
        $front = $this->bootstrap->getResource('FrontController');

        $plugins = $front->getPlugins();
        array_walk($plugins, function(&$value, $key) {
            $value = get_class($value);
        });

        $expectedPlugins = array(
            $this->getNamespace() . '\Plugin\ContentMonitor'
        );

        /* ensure plugin contained only once */
        foreach( $expectedPlugins as $key ) {
            $valuesCount = array_count_values($plugins);

            $this->assertTrue(false !== array_search($key, $plugins));
            $this->assertEquals(1, $valuesCount[$key]);
        }
    }

    /**
     * @desc Strips the Tests from the __NAMESPACE__.
     *
     * @return string The namespace
     */
    private function getNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }
}

BootstrapTest::runAlone();
