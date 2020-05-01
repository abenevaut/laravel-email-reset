<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config as ConfigFacade;
use PHPUnit\Framework\TestCase;
use Yaquawa\Laravel\EmailReset\Config;

class ConfigTest extends TestCase
{

    public function testDriverConfig()
    {
        $driver = 'driver';
//        ConfigFacade::shouldReceive('get')
//            ->once()
//            ->with("auth.email-reset.{$driver}")
//            ->andReturn([
//                'default' => [
//                    'table'  => 'email_resets',
//                    'expire' => 60,
//                    'callback' => 'App\Http\Controllers\Auth\ResetEmailController@reset',
//                ]
//            ]);

        (new Config())->driverConfig($driver);
    }

//    public function testDefaultDriver()
//    {
//        ConfigFacade::shouldReceive('get')
//            ->once()
//            ->with('auth.defaults.email-reset')
//            ->andReturn('default');
//
//        $this->config->defaultDriver();
//    }

//    public function testDefaultDriverConfig()
//    {
//        ConfigFacade::shouldReceive('get')
//            ->twice()
//            ->with('auth.defaults.email-reset')
//            ->andReturn('default')
//            ->with("auth.email-reset.default")
//            ->andReturn([
//                'default' => [
//                    'table'  => 'email_resets',
//                    'expire' => 60,
//                    'callback' => 'App\Http\Controllers\Auth\ResetEmailController@reset',
//                ]
//            ]);
//
//        $this->config->defaultDriverConfig('driver');
//    }
}
