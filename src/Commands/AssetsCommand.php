<?php

namespace MAteDon\Admin\Commands;

use Illuminate\Console\Command;

class AssetsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create symlinks for the admin assets';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->symlinkAssets();
    }

    protected function symlinkAssets()
    {
        $assetsPath = __DIR__ . '/../../assets';
        $publicPath = public_path();
        $packagesPath = $publicPath . '/packages/admin';
        if ($this->laravel->make('files')->link($assetsPath, $packagesPath)) {
            $this->info('LINK CREATED: ' . $packagesPath);
        }
    }
}
