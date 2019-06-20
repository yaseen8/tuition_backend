<?php

namespace App\Models\AppCourseFeeModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppNewCourseModel\NewCourse;

class CourseFee extends Model
{
    public $table='course_fee';
    protected $fillable=['fee', 'fk_new_course_id'];
    public $timestamps = false;

    public function new_course()
    {
        return $this->belongsTo(NewCourse::class, 'fk_new_course_id');
    }
}
