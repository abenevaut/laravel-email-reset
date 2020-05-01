<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        $app = (new Application(dirname(__DIR__)))
            ->setBasePath(__DIR__ . '/app')
            ->useAppPath(__DIR__ . '/app/app')
            ->useStoragePath(__DIR__ . '/app/storage');
        $app->singleton(Kernel::class, ConsoleKernel::class);
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
