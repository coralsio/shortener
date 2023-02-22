<?php

namespace Corals\Modules\Shortener\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Shortener\database\migrations\ShortenerTables;
use Corals\Modules\Shortener\database\seeds\ShortenerDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

    protected $migrations = [
        ShortenerTables::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $shortenerDatabaseSeeder = new ShortenerDatabaseSeeder();

        $shortenerDatabaseSeeder->run();
    }
}
