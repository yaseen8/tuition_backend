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

Route::get('/courses', 'CoursesController@index');
Route::post('/courses', 'CoursesController@store');
Route::put('/courses/{id}', 'CoursesController@update');
Route::get('/course/get_by_study_level/{id}', 'CoursesController@get_by_study_level');

//////Study Level Api

Route::get('/study_level', 'StudyLevelController@index');
Route::post('/study_level', 'StudyLevelController@store');
Route::put('/study_level/{id}', 'StudyLevelController@update');

//New Course

Route::post('/new_course', 'NewCourseController@create');



