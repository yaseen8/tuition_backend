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
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|string',

        ]);
        $courses=$this->model->create($request->all());
        return response()->json($courses, 201);
    }
}
