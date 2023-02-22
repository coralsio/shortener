<?php

namespace Corals\Modules\Shortener\Providers;

use Corals\Modules\Shortener\Models\Impression;
use Corals\Modules\Shortener\Models\Link;
use Corals\Modules\Shortener\Models\ShortDomain;
use Corals\Modules\Shortener\Models\TrackingPixel;
use Corals\Modules\Shortener\Policies\ImpressionPolicy;
use Corals\Modules\Shortener\Policies\LinkPolicy;
use Corals\Modules\Shortener\Policies\ShortDomainPolicy;
use Corals\Modules\Shortener\Policies\TrackingPixelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ShortenerAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Link::class => LinkPolicy::class,
        ShortDomain::class => ShortDomainPolicy::class,
        Impression::class => ImpressionPolicy::class,
        TrackingPixel::class => TrackingPixelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
