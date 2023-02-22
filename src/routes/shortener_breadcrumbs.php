<?php

use Corals\Foundation\Facades\Breadcrumb\Breadcrumbs;

//Link
Breadcrumbs::register('shortener_links', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Shortener::module.link.title'), url(config('shortener.models.link.resource_url')));
});

Breadcrumbs::register('shortener_link_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('shortener_links');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('shortener_link_show', function ($breadcrumbs) {
    $breadcrumbs->parent('shortener_links');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//shortDomain
Breadcrumbs::register('shortener_shortDomains', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Shortener::module.shortDomain.title'), url(config('shortener.models.shortDomain.resource_url')));
});

Breadcrumbs::register('shortener_shortDomain_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('shortener_shortDomains');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('shortener_shortDomain_show', function ($breadcrumbs) {
    $breadcrumbs->parent('shortener_shortDomains');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//impressions

Breadcrumbs::register('shortener_impressions', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Shortener::module.impression.title'), url(config('shortener.models.impression.resource_url')));
});


//tracking_pixels

Breadcrumbs::register('shortener_tracking_pixels', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Shortener::module.tracking_pixel.title'), url(config('shortener.models.tracking_pixel.resource_url')));
});

Breadcrumbs::register('shortener_tracking_pixel_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('shortener_tracking_pixels');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('shortener_tracking_pixel_show', function ($breadcrumbs) {
    $breadcrumbs->parent('shortener_tracking_pixels');
    $breadcrumbs->push(view()->shared('title_singular'));
});
