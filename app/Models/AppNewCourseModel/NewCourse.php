<?php

namespace App\Models\AppNewCourseModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppUserModel\User;
use App\Models\AppCoursesModel\Courses;
use App\Models\AppCourseFeeModel\CourseFee;
use App\Models\AppCourseScheduleModel\CourseSchedule;
use App\Models\AppTeacherDetailModel\TeacherDetail;



class NewCourse extends Model
{
    public $table='new_course';
    protected $fillable=['title','max_student', 'status', 'start_date', 'end_date', 'description', 'fk_teacher_id', 'fk_course_id'];
    public $timestamps = false;

    public function teacher()
    {
        return $this->belongsTo(User::class, 'fk_teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'fk_course_id');
    }

    public function course_fee()
    {
        return $this->hasOne(CourseFee::class,'fk_new_course_id');
    }

    public function schedule()
    {
        return $this->hasMany(CourseSchedule::class, 'fk_new_course_id');
    }

    public function teacher_detail()
    {
        return $this->hasOne(TeacherDetail::class, 'fk_new_course_id');
    }

}
