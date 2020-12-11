<?php

namespace abenevaut\Laravel\EmailReset;

use InvalidArgumentException;
use Illuminate\Support\Str;
use abenevaut\Laravel\TokenRepository\DatabaseTokenRepository;
use abenevaut\Laravel\EmailReset\Contracts\EmailResetBroker as EmailResetBrokerInterface;

class EmailResetBrokerFactory
{
    /**
     * The array of created "drivers".
     *
     * @var array
     */
    protected static $brokers = [];

    public static function broker($name = null)
    {
        $name = $name ?: Config::defaultDriver();

        return isset(static::$brokers[$name])
            ? static::$brokers[$name]
            : static::$brokers[$name] = static::resolve($name);
    }

    /**
     * Add a broker(driver).
     *
     * @param $name
     * @param EmailResetBrokerInterface $broker
     */
    public static function addBroker($name, EmailResetBrokerInterface $broker): void
    {
        static::$brokers[$name] = $broker;
    }

    /**
     * Resolve the given broker.
     *
     * @param  string $name
     *
     * @return EmailResetBroker
     * @throws \InvalidArgumentException
     */
    protected static function resolve($name)
    {
        $config = Config::driverConfig($name);

        if (null === $config) {
            throw new InvalidArgumentException("Email reset driver [{$name}] is not defined.");
        }

        return new EmailResetBroker(
            static::createTokenRepository($config)
        );
    }

    /**
     * Create a token repository instance based on the given configuration.
     *
     * @param  array $config
     *
     * @return DatabaseTokenRepository
     */
    protected static function createTokenRepository(array $config)
    {
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $connection = $config['connection'] ?? null;

        // phpcs:ignore @phpstan-ignore-next-line
        return new DatabaseTokenRepository(
            app('db')->connection($connection),
            app('hash'),
            $config['table'],
            $key,
            $config['expire'],
            [static::class, 'payloadFilter']
        );
    }

    /**
     * Modify the record before inserting into the database.
     *
     * @param array $payLoad
     * @param $user
     *
     * @return array
     */
    public static function payloadFilter(array $payLoad, $user): array
    {
        $payLoad['new_email'] = $user->new_email;

        return $payLoad;
    }
}
