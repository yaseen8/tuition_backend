<?php

namespace App\Models\AppCoursesModel;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    public $table='courses';
    protected $fillable=['title','fk_study_level_id'];
    public $timestamps = false;

    public function study_level()
    {
        return $this->belongsTo('App\Models\AppStudyLevelModel\StudyLevel'::class, 'fk_study_level_id');
    }
}
