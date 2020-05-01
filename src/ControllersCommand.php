<?php

namespace Yaquawa\Laravel\EmailReset;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class ControllersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email-reset:controllers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold the email-reset controllers';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (! is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__.'/../stubs/Auth'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $fileName = Str::replaceLast('.stub', '.php', $file->getFilename());
                $filesystem->copy(
                    $file->getPathname(),
                    app_path("Http/Controllers/Auth/{$fileName}")
                );
            });

        $this->info('EmailReset scaffolding generated successfully.');
    }
}