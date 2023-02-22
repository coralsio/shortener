<?php

namespace Corals\Modules\Shortener;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Shortener\Console\Commands\GenerateCodes;
use Corals\Modules\Shortener\Facades\Shortener;
use Corals\Modules\Shortener\Models\Link;
use Corals\Modules\Shortener\Providers\ShortenerAuthServiceProvider;
use Corals\Modules\Shortener\Providers\ShortenerObserverServiceProvider;
use Corals\Modules\Shortener\Providers\ShortenerRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;

class ShortenerServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $defer = true;
    /**
     * @var
     */
    protected $packageCode = 'corals-shortener';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */

    public function bootPackage()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Shortener');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Shortener');

        $this->registerCustomFieldsModels();

        $this->commands(GenerateCodes::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPackage()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/shortener.php', 'shortener');

        $this->app->register(ShortenerRouteServiceProvider::class);
        $this->app->register(ShortenerAuthServiceProvider::class);
        $this->app->register(ShortenerObserverServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Shortener', Shortener::class);
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Link::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/shortener');
    }
}
