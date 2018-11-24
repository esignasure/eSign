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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/myfiles', 'HomeController@myfiles')->name('myfiles');
    Route::get('get-folders', 'MyFiles@index')->name('folders');
    Route::get('get-sub-folders/{folderId}', 'MyFiles@getSubFolders');
    Route::post('create-folder', 'MyFiles@createFolder');
    Route::delete('delete-folder/{folderId}', 'MyFiles@deleteFolder');
});

//Route::group(['prefix' => 'admin',  'middleware' => 'auth:admin'], function() {
//    Route::get('home','HomeController@index')->name('home');
//    Route::post('logout','HomeController@logout')->name('admin.logout');
//});
