<?php

namespace Corals\Modules\Shortener\Providers;

use Corals\Modules\Shortener\Models\Link;
use Corals\Modules\Shortener\Observers\LinkObserver;
use Illuminate\Support\ServiceProvider;

class ShortenerObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        Link::observe(LinkObserver::class);
    }
}
