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

    public function book_course(Request $request)
    {
        $book_course = BookCourse::create($request->only('fk_new_course_id','fk_student_id'));
        if($book_course)
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
                $resp=CoursePayment::create($request->only('status','fk_new_course_id','fk_student_id')
                    +['image'=>$destination_path . '/' . $picName]
                );
                return response()->json($resp);
            }
            else
            {
                $resp=CoursePayment::create($request->only('status','fk_new_course_id','fk_student_id'));
                return response()->json($resp);
            }
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
}
