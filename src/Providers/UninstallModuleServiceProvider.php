<?php

namespace Corals\Modules\Shortener\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Shortener\database\migrations\ShortenerTables;
use Corals\Modules\Shortener\database\seeds\ShortenerDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        ShortenerTables::class
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $shortenerDatabaseSeeder = new ShortenerDatabaseSeeder();

        $shortenerDatabaseSeeder->rollback();
    }
}
