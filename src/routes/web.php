<?php

use Illuminate\Support\Facades\Route;

Route::get('l/{code}', 'ImpressionsController@click');

Route::get('s/{code}', 'ShortenerPublicController@splashPage');

Route::group(['prefix' => 'shortener'], function () {
    Route::resource('links', 'LinksController');
    Route::resource('short-domains', 'ShortDomainsController');
    Route::resource('impressions', 'ImpressionsController')->only('index');
    Route::resource('tracking-pixels', 'TrackingPixelsController')->except('show');
});
