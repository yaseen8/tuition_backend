<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppStudyLevelModel\StudyLevel;

class StudyLevelController extends Controller
{
    protected $model;
    public function __construct(StudyLevel $model)
    {
        $this->model=$model;
        $this->middleware('auth');
    }

    public function index()
    {
        $study_level=$this->model->get();
        return response()->json($study_level, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|string',

        ]);
        $study_level=$this->model->create($request->all());
        return response()->json($study_level, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'sometimes|string',

        ]);
        $level = $this->model::find($id);
        if($level){
            $level->update($request->all());
            return response()->json($level);
        };
        return response()->json(false);
    }
}
