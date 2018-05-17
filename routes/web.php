<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'GithubController@index')->name('search'); // Return VIEW for searching users
Route::post('/', 'GithubController@index')->name('search'); // Return VIEW for searching users
Route::get('/user-{name}', 'GithubController@profile')->name('profile'); // Return VIEW user's profile

Route::get('/search/user/{name}', 'SearchController@searchUser')->name('user-search'); // Return JSON user object
Route::post('/search/followers', 'SearchController@searchFollowers')->name('followers-search'); // Return JSON list of user's followers

