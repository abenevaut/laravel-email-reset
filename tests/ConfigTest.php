<?php

namespace Yaquawa\Tests;

use PHPUnit\Framework\TestCase;
use Yaquawa\Laravel\EmailReset\Config;

class ConfigTest extends TestCase
{
    protected $config;

    protected function setUp(): void
    {
        $this->config = new Config();
    }

    public function testToGetDriverConfig()
    {
        $fakeDriver = 'driver';
        $driverEquals = "auth.email-reset.{$fakeDriver}";
        $driver = $this->config->driverConfig($fakeDriver);
        $this->assertEquals($driverEquals, $driver);
    }

    public function testToGetDefaultDriver()
    {
        $driver = $this->config->defaultDriver();
        $this->assertEquals('auth.defaults.email-reset', $driver);
    }
}
