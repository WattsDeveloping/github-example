<?php

use Illuminate\Support\Facades\Route;

/**
 * Initial Route to handle the search Page
 */
Route::get('/', function () {
    return view('/pages/search');
});

/**
 * Secondary route to handle the searching
 */
Route::get('/search', 'App\Http\Controllers\SearchController@getSearchResults');

