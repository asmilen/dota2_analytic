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
Route::get('admin/login', 'AdminController@redirectToGoogle');
Route::get('admin/logout', 'AdminController@logout');
Route::get('admin/callback', 'AdminController@handleGoogleCallback');
Route::get('admin/notice', 'AdminController@notice');
Route::get('admin', 'AdminController@index');
Route::post('admin/ajax', 'AdminController@ajax');
Route::get('admin/export/{id}', 'ProjectsController@export');
#Content Routes
foreach (config('site.content') as $content => $config) {
    Route::resource('admin/'.$content, ucfirst($content).'Controller');
}
Route::resource('admin/modules', 'ModulesController');
#Frontend Routes
Route::get('login', 'AuthController@redirectToAuthServer');
Route::get('logout', 'AuthController@logout');
Route::get('callback', 'AuthController@callback');
Route::get('logoutError','MainController@redirectToLogoutError');

Route::get('user', 'FrontendController@user');

Route::get('/', function () {
    return view('welcome');
});
