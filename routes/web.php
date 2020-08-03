<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

  Route::get('/', 'UserController@index');
   Route::get('add-user', 'UserController@addUserForm')->name('add.user');
    Route::post('add-user-data', 'UserController@addUserData')->name('add.userData');
     Route::post('add-user', 'UserController@deleteUser')->name('delete.user');
      Route::get('edit-user/{id}', 'UserController@editUserForm')->name('edit.user');

       Route::post('update-user', 'UserController@updateUser')->name('update.user');