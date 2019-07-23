<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppBookCourseModel\BookCourse;
use App\Models\AppCoursePaymentModel\CoursePayment;
use Illuminate\Support\Facades\Storage;

class BookCourseController extends Controller
{

    protected $model;
    public function __construct(BookCourse $model)
    {
        $this->model=$model;
        $this->middleware('auth');
    }

    public function get_user_booking(Request $request)
    {
        $status = $request->input('status');
        $new = 'new';
        $pending = 'pending';
        if($status == 'new') {
            $user_course = BookCourse::with('course_payment','new_course', 'new_course.course_fee', 'new_course.schedule')
            ->where('fk_student_id', $request->user()->id)
            ->whereHas('new_course', function ($query) {
                $query->where('status', \Request::input('status'));
                })
            ->whereHas('course_payment', function ($query) {
                $query->where('status', 'pending');
                })
            ->orderBy('timestamp', 'desc')  
            ->get();
            return response()->json($user_course, 200);
        }
        if($status == 'in_progress') {
            $user_course = BookCourse::with('course_payment','new_course', 'new_course.course_fee', 'new_course.schedule')
            ->where('fk_student_id', $request->user()->id)
            ->whereHas('course_payment', function ($query) {
                $query->where('status', 'approved');
                })
            ->whereHas('new_course', function ($query) {
                $query->where(function($q) use ($query) {
                    $q->where('status', 'in_progress')
                      ->orWhere('status', 'new');
                });
                })
            ->orderBy('timestamp', 'desc')  
            ->get();
            return response()->json($user_course, 200);
        }
        if($status == 'completed') {
            $user_course = BookCourse::with('course_payment','new_course', 'new_course.course_fee', 'new_course.schedule')
            ->where('fk_student_id', $request->user()->id)
            ->whereHas('new_course', function ($query) {
                $query->where('status', \Request::input('status'));
                })
            ->whereHas('course_payment', function ($query) {
                $query->where('status', 'approved');
                })
            ->orderBy('timestamp', 'desc')  
            ->get();
            return response()->json($user_course, 200);
        }
    
    }

    public function book_course(Request $request)
    {
        $book_course = BookCourse::create(
            [
                'fk_new_course_id' =>  $request->input('fk_new_course_id'),
                'fk_student_id' =>  $request->user()->id
            ]
        );
        if($book_course)
        {
            $resp = CoursePayment::create(
                [
                'status' =>  $request->input('status'),
                'fk_book_course_id' => $book_course->id
                ]
            );
            if($resp)
            {
                return response()->json($book_course, 200);
            }
           return response()->json(false);

        }
        return response()->json(false);
    }

    public function update_payment_status(Request $request, $id)
    {
        $payment = CoursePayment::find($id);
        if($payment)
        {
            $payment->update(['status' => $request->input('status')]);
            return response()->json($payment, 200);
        }
        return response()->json('not found', 404);
    }

    public function upload_payment_image(Request $request)
    {
            if($request->hasFile('image')){
                $picName = $request->file('image')->hashName();
                $destination_path = 'upload/'.$request->user()->username.'/payment';
                $disk_name=env('DISK');
                $disk=Storage::disk($disk_name);
                if($disk_name == 'gcs'){
                    $disk->putFileAs($destination_path, $request->file('image'),$picName,'public');
                }else{
                    $request->file('image')->move($destination_path, $picName);

                };
                $payment = CoursePayment::find($request->input('id'));
                if($payment)
                {
                    $payment->update(['image'=>$destination_path . '/' . $picName]);
                    return response()->json($payment, 200);
                }
                return response()->json(false, 404);
            }      
    }
    
    public function get_user_payments(Request $request)
    {
        $status = $request->input('status');
        $payments = CoursePayment::with('book_course', 'book_course.new_course', 'book_course.new_course.course_fee', 'book_course.new_course.schedule')
                        ->where('status' ,$status)
                        ->whereHas('book_course', function ($query) {
                            $query->where('fk_student_id', \Request::user()->id);
                            })  
                            ->get();
        return response()->json($payments, 200);
    }

    public function check_already_booked_course(Request $request)
    {
        $course_id = $request->input('id');
        $check = BookCourse::where('fk_new_course_id', $course_id)
                            ->where('fk_student_id', $request->user()->id)
                            ->first();
        if($check) {
            return response()->json($check, 200);
        }
    }
}
