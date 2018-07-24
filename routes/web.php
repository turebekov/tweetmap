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



Route::get('/homeTimeline', 'TwitterController@homeTimeline');
Route::get('/twitterUserTimeLine', 'TwitterController@twitterUserTimeLine');
Route::get('/', 'TwitterController@twitmap');
Route::get('twits', 'TwitterController@getTwits');
Route::post('saveTweet','TwitterController@saveTweet');
Route::post('tweet', ['as' => 'post.tweet', 'uses' => 'TwitterController@tweet']);