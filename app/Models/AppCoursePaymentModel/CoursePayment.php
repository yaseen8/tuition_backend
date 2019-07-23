<?php

namespace App\Models\AppCoursePaymentModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppBookCourseModel\BookCourse;

class CoursePayment extends Model
{
    public $table='course_payment';
    protected $fillable=['timestamp','status','image', 'fk_book_course_id'];
    public $timestamps = false;

    public function book_course()
    {
        return $this->belongsTo(BookCourse::class, 'fk_book_course_id');
    }
}
