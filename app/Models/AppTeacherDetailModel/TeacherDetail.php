<?php

namespace App\Models\AppTeacherDetailModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppNewCourseModel\NewCourse;

class TeacherDetail extends Model
{
    public $table='teacher_detail';
    protected $fillable=['description', 'fk_new_course_id'];
    public $timestamps = false;

    public function new_course()
    {
        return $this->belongsTo(NewCourse::class, 'fk_new_course_id');
    }
}
