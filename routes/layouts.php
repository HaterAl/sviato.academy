<?php

use Illuminate\Support\Facades\Route;

if (app()->environment() == 'local') {
    Route::group(['prefix' => '_l', 'as' => '_l.'], function () {
        Route::get('/', fn() => view('_l.pages._dump'));
        Route::get('/home', fn() => view('_l.pages.home'))->name('home');
        Route::get('/error', fn() => view('_l.pages.error'))->name('error');
    });
}
