<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'shortener'], function () {
    Route::get('click/{code}', 'ImpressionsController@click');
    Route::get('links/{code}', 'LinksController@show');
    Route::resource('links', 'LinksController', ['only' => ['index', 'store']]);
});
