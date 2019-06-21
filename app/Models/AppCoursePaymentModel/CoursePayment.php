<?php

namespace App\Models\AppCoursePaymentModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppNewCourseModel\NewCourse;
use App\Models\AppUserModel\User;

class CoursePayment extends Model
{
    public $table='course_payment';
    protected $fillable=['timestamp','status','image', 'fk_new_course_id', 'fk_student_id'];
    public $timestamps = false;

    public function new_course()
    {
        return $this->belongsTo(NewCourse::class, 'fk_new_course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_student_id');
    }
}
