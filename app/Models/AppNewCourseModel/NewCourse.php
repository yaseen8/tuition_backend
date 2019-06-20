<?php

namespace App\Models\AppNewCourseModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppUserModel\User;
use App\Models\AppCoursesModel\Courses;

class NewCourse extends Model
{
    public $table='new_course';
    protected $fillable=['title','max_student', 'status', 'start_date', 'end_date', 'description', 'fk_teacher_id', 'fk_course_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'fk_course_id');
    }
}
