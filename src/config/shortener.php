<?php

return [
    'models' => [
        'link' => [
            'presenter' => \Corals\Modules\Shortener\Transformers\LinkPresenter::class,
            'resource_url' => 'shortener/links',
        ],
        'urlCode' => [
        ],
        'shortDomain' => [
            'presenter' => \Corals\Modules\Shortener\Transformers\ShortDomainPresenter::class,
            'resource_url' => 'shortener/short-domains',
        ],

        'impression' => [
            'presenter' => \Corals\Modules\Shortener\Transformers\ImpressionPresenter::class,
            'resource_url' => 'shortener/impressions',
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ],
        'tracking_pixel' => [
            'presenter' => \Corals\Modules\Shortener\Transformers\TrackingPixelPresenter::class,
            'resource_url' => 'shortener/tracking-pixels',
            'providers' => [
                'GTM' => 'Google Tag Manager',
                'FB' => 'Facebook Pixel'
            ]
        ]
    ]
];
