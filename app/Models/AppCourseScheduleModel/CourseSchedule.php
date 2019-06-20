<?php

namespace App\Models\AppCourseScheduleModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppNewCourseModel\NewCourse;


class CourseSchedule extends Model
{
    public $table='course_schedule';
    protected $fillable=['day', 'start_time', 'end_time', 'fk_new_course_id'];
    public $timestamps = false;

    public function new_course()
    {
        return $this->belongsTo(NewCourse::class, 'fk_new_course_id');
    }
}
