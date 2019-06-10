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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/admin/users', 'AdminController@index_users')->name('admin-users');

Route::get('/admin/exams/{level_id?}/{question_id?}/{do?}', 'ExamController@index')->name('admin-exams');

Route::post('/admin/exams/{level_id?}/create', 'ExamController@submit_question')->name('admin-exams-create');

Route::get('/logout', 'UserController@logout')->name('logout');