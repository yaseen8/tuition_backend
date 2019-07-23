<?php

namespace App\Models\AppBookCourseModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppNewCourseModel\NewCourse;
use App\Models\AppUserModel\User;
use App\Models\AppCoursePaymentModel\CoursePayment;

class BookCourse extends Model
{
    public $table='book_course';
    protected $fillable=['timestamp', 'fk_new_course_id', 'fk_student_id'];
    public $timestamps = false;

    public function new_course()
    {
        return $this->belongsTo(NewCourse::class, 'fk_new_course_id');
    }

    public function course_payment()
    {
        return $this->hasOne(CoursePayment::class, 'fk_book_course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_student_id');
    }
}
