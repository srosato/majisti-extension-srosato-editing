<?php

namespace MajistiX\Tests\Editing\Util\Filter;

use \Majisti\Config\Configuration,
    \MajistiX\Editing\Util\Filter\StaticUrl
;

require_once __DIR__ . '/TestHelper.php';

class StaticUrlTest extends \Majisti\Test\TestCase
{
    /**
     * @var Configuration 
     */
    public $conf;

    public $filter;

    public function setUp()
    {
        $this->conf = new Configuration(
            $this->getHelper()->createBootstrapInstance()->getOptions());

        $this->filter = new StaticUrl($this->conf);
    }

    public function testFilter()
    {
        $filter = $this->filter;

        $value = "##{majisti.app.url}##/foo.jpg";
        $this->assertEquals("{$this->conf->find('majisti.app.url')}/foo.jpg", 
            $filter->filter($value));

        $value = "##{majisti.url}##/foo.jpg";
        $this->assertEquals("{$this->conf->find('majisti.url')}/foo.jpg", 
            $filter->filter($value));

        $value = 'http://google.ca/foo.jpg';
        $this->assertEquals($value, $filter->filter($value));
    }
}

StaticUrlTest::runAlone();
