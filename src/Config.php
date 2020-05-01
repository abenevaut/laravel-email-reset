<?php

namespace Yaquawa\Laravel\EmailReset;

use Illuminate\Support\Facades\Config as ConfigFacade;

class Config
{
    /**
     * Get the email reset broker configuration.
     *
     * @param string $driver
     *
     * @return array
     */
    public static function driverConfig(string $driver): array
    {
        return ConfigFacade::get("auth.email-reset.{$driver}");
    }

    /**
     * Get the default email reset broker name.
     *
     * @return string
     */
    public static function defaultDriver(): string
    {
        return ConfigFacade::get('auth.defaults.email-reset');
    }

    /**
     * Get the default driver's config.
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public static function defaultDriverConfig(string $key = null)
    {
        $config = static::driverConfig(static::defaultDriver());

        return $key
            ? ($config[$key] ?? null)
            : $config;
    }
}