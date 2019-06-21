<?php

namespace App\Http\Controllers;
use App\Models\AppNewCourseModel\NewCourse;
use App\Models\AppCourseFeeModel\CourseFee;
use App\Models\AppCourseScheduleModel\CourseSchedule;
use App\Models\AppTeacherDetailModel\TeacherDetail;

use Illuminate\Http\Request;

class NewCourseController extends Controller
{
    protected $model;
    public function __construct(NewCourse $model)
    {
        $this->model=$model;
//        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $new_course = NewCourse::create(
            [
                'title' => $request->input('title'),
                'max_student' => $request->input('max_student'),
                'status' => $request->input('status'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'description' => $request->input('course_description'),
                'fk_teacher_id' => $request->input('fk_teacher_id'),
                'fk_course_id' => $request->input('fk_course_id')
            ]
        );
        if($new_course) {
            $fee = CourseFee::create(
                [
                    'fee' => $request->input('fee'),
                    'fk_new_course_id' => $new_course->id
                ]
            );
            if($fee) {
                foreach ($request->input('schedule') as $sche) {
                    $schedule = CourseSchedule::create(
                        [
                            'day' => $sche['day'],
                            'start_time' => $sche['start_time'],
                            'end_time' => $sche['end_time'],
                            'fk_new_course_id' => $new_course->id
                        ]
                    );
                }

                if($schedule) {
                    $teacher = TeacherDetail::create(
                        [
                            'description' => $request->input('teacher_description'),
                            'fk_new_course_id' => $new_course->id
                        ]
                    );
                }
            }
            return response()->json($new_course, 201);
        }
        return response()->json(false);
    }

    public function update_course(Request $request, $id)
    {
        $course = NewCourse::find($id);
        if($course)
        {
            $course->update(request()->all());
            return response()->json($course, 200);
        }
        return response()->json('not found', 404);
    }

    public function update_fee(Request $request, $id)
    {
        $fee = CourseFee::find($id);
        if($fee)
        {
            $fee->update(request()->all());
            return response()->json($fee, 200);
        }
        return response()->json('not found', 404);
    }
}
