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
Route::post('/logout', 'AuthController@logout');
Route::get('/logged_in_user', 'UserController@loggedInUser');
Route::get('/users/select_list', 'UserController@user_select_list');
Route::get('/users/list', 'UserController@user_list');
Route::post('/register', 'UserController@create');
Route::put('/user/{id}', 'UserController@update');
Route::get('/check_username', 'UserController@check_username');
Route::get('/check_email', 'UserController@check_email');

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
Route::put('/update_course/{id}', 'NewCourseController@update_course');
Route::put('/update_fee/{id}', 'NewCourseController@update_fee');
Route::get('/course_list', 'NewCourseController@course_list');
Route::get('/get_course_detail/{id}', 'NewCourseController@get_course_detail');

//Book Course

Route::post('/book_course', 'BookCourseController@book_course');
Route::get('/get_user_booking', 'BookCourseController@get_user_booking');
Route::put('/update_payment_status/{id}', 'BookCourseController@update_payment_status');
Route::get('/get_user_payments', 'BookCourseController@get_user_payments');
Route::post('/upload_payment_image', 'BookCourseController@upload_payment_image');
Route::get('/check_already_booked_course', 'BookCourseController@check_already_booked_course');

