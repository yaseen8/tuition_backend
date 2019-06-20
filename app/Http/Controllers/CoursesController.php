<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppCoursesModel\Courses;

class CoursesController extends Controller
{
    protected $model;
    public function __construct(Courses $model)
    {
        $this->model=$model;
//        $this->middleware('auth');
    }

    public function index()
    {
        $courses=$this->model->with('study_level')->get();
        return response()->json($courses, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|string',
            'fk_study_level_id' => 'required'

        ]);
        $course=$this->model->create(request()->all());
        return response()->json($course, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'sometimes|string',
            'fk_study_level_id' => 'required'

        ]);
        $course = Courses::find($id);
        if($course){
            $course->update(request()->all());
            return response()->json($course);
        };
        return response()->json(false);
    }

    public function get_by_study_level(Request $request, $id)
    {
        $course = Courses::where('fk_study_level_id', $id)->get();
        if($course) {
            return response()->json($course, 200);
        }
        return response()->json('not found',404);
    }
}
