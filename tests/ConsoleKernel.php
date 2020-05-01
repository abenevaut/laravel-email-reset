<?php

namespace Tests;

use Illuminate\Foundation\Console\Kernel;
use Yaquawa\Laravel\EmailReset\ControllersCommand;

class ConsoleKernel extends Kernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ControllersCommand::class
    ];
}
