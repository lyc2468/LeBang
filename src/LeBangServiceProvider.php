<?php

namespace Skies\LeBang;

use Skies\LeBang\Commands\LeBangCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LeBangServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lebang')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_lebang_table')
            ->hasCommand(LeBangCommand::class);
    }
}
