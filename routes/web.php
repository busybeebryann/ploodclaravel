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

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', 'HomeController@index');

/**************************************
*      Routes for Login and Auth       *
***************************************/
Route::get('/login', 'UserController@showLoginPage');
Route::get('/home', 'HomeController@index');
Route::get('/password', 'UserController@showPasswordPage');
Route::post('/checkUsername', 'UserController@checkUsername');
Route::post('/loginUser', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/checkIfActive', 'UserController@checkIfActive');
Route::get('/logoutDeactivated', 'UserController@logoutDeactivated');


/**************************************
*        Routes for User Module       *
***************************************/

Route::resource('users', 'UserController');
Route::get('/users/{user_id}/deactivate', 'UserController@deactivate');
Route::get('/users/{user_id}/activate', 'UserController@activate');

/**************************************
*      Routes for Project Module      *
***************************************/

Route::get('/projects/archived', 'ProjectController@getArchivedProjects');
Route::resource('projects', 'ProjectController');
Route::get('/projects/{project_id}/deactivate', 'ProjectController@deactivate');
Route::get('/projects/archive', 'ProjectController@archive');


/**************************************
*   Routes for Project Report Module   *
***************************************/

Route::resource('project_reports', 'ProjectReportController', [ 'only' => [
	'store'
]]);

/**************************************
*      Routes for Comment Module      *
***************************************/

Route::post('/comments', 'CommentController@store');

/**************************************
*      Routes for Project File Module *
***************************************/

Route::resource('project_file', 'ProjectFileController', [
    'only' => ['store', 'destroy','download', 'delete']
]);
Route::post('/upload', 'ProjectFileController@store');
Route::post('/download', 'ProjectFileController@download');
Route::delete('{project_file_id}/{file_path}/delete', 'ProjectFileController@destroy');
Route::post('/delete', 'ProjectFileController@delete');

/**************************************
*      Routes for User Log Module     *
***************************************/

Route::get('/user_logs', 'UserLogController@index');


/**************************************
*      Routes for Hearing File Module *
***************************************/
Route::get('/reports/hearing', 'HearingReportController@index');
Route::get('/reports/hearing/{id}', 'HearingReportController@store');

/**************************************
*      Routes for Create File PDF     *
***************************************/
Route::get('pdfview','PdfGenerateController@pdfview');
//Route::get('/download-pdf','PdfGenerateController@downloadPDF');
Route::get('download-pdf','PdfGenerateController@downloadPDF');

