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

#Admin Routes
Route::get('admin/login', 'Backend\AdminController@redirectToGoogle');
Route::get('admin/logout', 'Backend\AdminController@logout');
Route::get('admin/callback', 'Backend\AdminController@handleGoogleCallback');
Route::get('admin/notice', 'Backend\AdminController@notice');
Route::get('admin', 'Backend\AdminController@index');
Route::post('admin/ajax', 'Backend\AdminController@ajax');
#Content Routes
foreach (config('site.content') as $content => $config) {
    Route::resource('admin/'.$content, 'Backend\\'.ucfirst($content).'Controller');
}
Route::resource('admin/modules', 'Backend\ModulesController');
#Frontend Routes
Route::get('login', 'Frontend\AuthController@redirectToAuthServer');
Route::get('logout', 'Frontend\AuthController@logout');
Route::get('callback', 'Frontend\AuthController@callback');
Route::get('logoutError','Frontend\AuthController@redirectToLogoutError');

Route::get('user', 'Frontend\FrontendController@user');

Route::get('/', function () {
    return view('welcome');
});
