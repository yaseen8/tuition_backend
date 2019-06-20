<?php

namespace App\Models\AppStudyLevelModel;

use Illuminate\Database\Eloquent\Model;

class StudyLevel extends Model
{
    public $table='study_level';
    protected $fillable=['title'];
    public $timestamps = false;

    public function courses(){
        return $this->hasMany(Courses::class);
    }
}
