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
        $makeFiles = $this->laravel->make('files');
        $assetsPath = __DIR__ . '/../../assets';
        $publicPath = public_path();
        $packagesPath = $publicPath . '/packages';
        if (!$makeFiles->exists($packagesPath)) {
            $makeFiles->makeDirectory($packagesPath);
        }
        $linkedPath = $packagesPath . '/admin';
        if ($makeFiles->link($assetsPath, $linkedPath)) {
            $this->info('LINK CREATED: ' . $linkedPath);
        }
    }
}
