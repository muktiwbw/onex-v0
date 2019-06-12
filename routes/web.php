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

// Route::match(['get','post','patch','delete'], '/admin/exams/{level_id?}/{question_id?}/{do?}', 'ExamController@index')->name('admin-exams');

// Shows list of exam levels
Route::get('/admin/exams', 'ExamController@index')->name('admin-exams');

// Shows list of tujuan, uraian, and questions in that level 
Route::get('/admin/level/{level_id}', 'ExamController@show_level')->name('admin-level');

// Shows form for creating tujuan
Route::get('/admin/level/{level_id}/tujuan/create', 'ExamController@create_tujuan')->name('admin-tujuan-create');
// Store new tujuan in DB
Route::post('/admin/tujuan/create', 'ExamController@store_tujuan')->name('admin-tujuan-store');

// Shows form for creating uraian
Route::get('/admin/level/{level_id}/uraian/create', 'ExamController@create_uraian')->name('admin-uraian-create');
// Store new uraian in DB
Route::post('/admin/uraian/create', 'ExamController@store_uraian')->name('admin-uraian-store');

// Shows specific question and its answers (essay or multiple choice)
Route::get('/admin/question/{question_id}', 'ExamController@show_question')->name('admin-question');
// Shows form for creating question
Route::get('/admin/level/{level_id}/question/create', 'ExamController@create_question')->name('admin-question-create');
// Store new question in DB
Route::post('/admin/level/{level_id}/question/create', 'ExamController@store_question')->name('admin-question-store');

Route::get('/logout', 'UserController@logout')->name('logout');