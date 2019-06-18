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

// Shows list of exam levels
Route::get('/admin/exams', 'ExamController@index')->name('admin-exams');

// ============= LEVEL
// Shows list of tujuan, uraian, and questions in that level 
Route::get('/admin/level/{level_id}', 'ExamController@show_level')->name('admin-level');

// ============= TUJUAN PEMBELAJARAN
// Shows form for creating tujuan
Route::get('/admin/level/{level_id}/tujuan/create', 'ExamController@create_tujuan')->name('admin-tujuan-create');
// Store new tujuan in DB
Route::post('/admin/tujuan/create', 'ExamController@store_tujuan')->name('admin-tujuan-store');

// ============= URAIAN MATERI
// Shows form for creating uraian
Route::get('/admin/level/{level_id}/uraian/create', 'ExamController@create_uraian')->name('admin-uraian-create');
// Store new uraian in DB
Route::post('/admin/uraian/create', 'ExamController@store_uraian')->name('admin-uraian-store');

// ============= STUDI KASUS
// Shows form for creating case study
Route::get('/admin/level/{level_id}/casestudy/create', 'ExamController@create_case_study')->name('admin-case-study-create');
// Store case study in DB
Route::post('/admin/casestudy/create', 'ExamController@store_case_study')->name('admin-case-study-store');
// Shows case study detail
Route::get('/admin/casestudy/{case_study_id}', 'ExamController@show_case_study')->name('admin-case-study');
// Shows form for editing case study
Route::get('/admin/casestudy/{case_study_id}/edit', 'ExamController@edit_case_study')->name('admin-case-study-edit');
// Patch case study in DB
Route::post('/admin/casestudy/patch', 'ExamController@patch_case_study')->name('admin-case-study-patch');
// Remove case study
Route::get('/admin/casestudy/{case_study_id}/remove', 'ExamController@remove_case_study')->name('admin-case-study-remove');

// ============= SOAL
// Shows specific question and its answers (essay or multiple choice)
Route::get('/admin/question/{question_id}', 'ExamController@show_question')->name('admin-question');
// Shows form for creating question
Route::get('/admin/level/{level_id}/question/create', 'ExamController@create_question')->name('admin-question-create');
// Store new question in DB
Route::post('/admin/question/create', 'ExamController@store_question')->name('admin-question-store');
// Shows form for editing question
Route::get('/admin/question/{question_id}/edit', 'ExamController@edit_question')->name('admin-question-edit');
// Patch question
Route::post('/admin/question/patch', 'ExamController@patch_question')->name('admin-question-patch');
// Remove question
Route::get('/admin/question/{question_id}/remove', 'ExamController@remove_question')->name('admin-question-remove');

Route::get('/logout', 'UserController@logout')->name('logout');

// ============= PENILAIAN DIRI
// Shows form for creating evaluation
Route::get('/admin/level/{level_id}/evaluation/create', 'ExamController@create_evaluation')->name('admin-evaluation-create');
// Store evaluation in DB
Route::post('/admin/evaluation/create', 'ExamController@store_evaluation')->name('admin-evaluation-store');
// Shows form for editing evaluation
Route::get('/admin/evaluation/{evaluation_id}/edit', 'ExamController@edit_evaluation')->name('admin-evaluation-edit');
// Patch evaluation in DB
Route::post('/admin/evaluation/patch', 'ExamController@patch_evaluation')->name('admin-evaluation-patch');
// Remove evaluation from DB
Route::get('/admin/evaluation/{evaluation_id}/remove', 'ExamController@remove_evaluation')->name('admin-evaluation-remove');