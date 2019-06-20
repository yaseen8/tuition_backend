<?php

// use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'AuthController@login')->name('login');
Route::get('/users/select_list', 'UserController@user_select_list');

/////Courses

Route::post('/course', 'CoursesController@store');

//////Study Level Api

Route::get('/study_level', 'StudyLevelController@index');
Route::post('/study_level', 'StudyLevelController@store');
Route::put('/study_level/{id}', 'StudyLevelController@update');


