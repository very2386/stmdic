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

Route::get('/', 'PagesController@index');
Route::get('/member_info/{id}', 'PagesController@member_info');
Route::get('/expert/{id?}', 'PagesController@expert');
Route::get('/product/{id?}', 'PagesController@product');
Route::get('/news/{type?}', 'PagesController@news');
Route::get('/event/{id?}', 'PagesController@event');
Route::get('/video/{id?}', 'PagesController@video');
Route::get('/marketing/{page}/{type?}/{id?}', 'PagesController@marketing');
Route::get('/calendar', 'PagesController@calendar');
Route::get('/statistics', 'PagesController@statistics');
Route::get('/post/{type?}', 'PagesController@post');
Route::get('/post_cat/{id?}', 'PagesController@post_cat');
Route::get('/post/post_edit/{id?}', 'PagesController@post_edit');
Route::get('/news_content/{id}', 'PagesController@news');
Route::get('/company/{id?}', 'PagesController@company');
Route::get('/company_hire_list/{id}', 'PagesController@company_hire_list');
Route::get('/company_hire/{id}', 'PagesController@company_hire');
Route::get('/job', 'PagesController@job');
Route::get('/information/{type}/{id?}', 'PagesController@information');
Route::get('/contact', 'PagesController@contact');
Route::get('/captcha','PagesController@captcha');
Route::get('/download/{id}', 'PagesController@download');
Route::get('/search/{type?}', 'PagesController@search');
Route::get('/member/{page?}/{id?}', 'PagesController@member');
Route::get('/resume/{id}', 'PagesController@resume');
Route::get('/files/{ftype?}/{type?}', 'PagesController@files');
Route::get('/get/{item}/{arg?}', 'PagesController@data');
Route::get('/social/login', 'PagesController@callback');
Route::get('/callback/google', 'PagesController@google_callback');
Route::get('/about/{page?}/{id?}', 'PagesController@about');
Route::get('/logout','BackendController@logout');
Route::get('/backend','BackendController@index');
Route::get('/backend/login','BackendController@login');
Route::get('/backend/logout','BackendController@logout');
Route::get('/backend/{page}/{func}/{arg?}','BackendController@page');
Route::get('/show_session','BackendController@show_session');
Route::get('/export/{actid}','BackendController@export');
Route::post('/do/{cmd}/{target?}','BackendController@do');
Route::get('/Test','TestController@test');
Route::get('/test/{cmd}','BackendController@test');
Route::get('/market','PagesController@market');
Route::get('/do/excel/{type}','BackendController@do_excel');
Route::get('/link', 'PagesController@link');
Route::get('/fix/{type}/{up_sn}','BackendController@do_fix');





