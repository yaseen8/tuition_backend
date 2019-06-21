<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUserModel\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
//        $this->middleware('auth');
        $this->user =  Auth::user();

    }

    public function user_list()
    {

        $users = User::paginate(25);
        return response()->json($users);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|max:255|unique:users,email',
            'password' => 'required',
            'username' => 'required|unique:users,username'
        ]);

            $user = User::create(request()->all());
            if($user)
            {
                return response()->json($user, 201);
            }
    }

    public function loggedInUser()
    {
        return response()->json(auth()->user(), 200);
    }

    public function user_select_list()
    {
       $user = User::get();
       return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);
        if($user) {
            if ($request->hasFile('image')) {
                $picName = $request->file('image')->hashName();
                $destination_path = 'upload/' . $this->user->username . '/profile';
                $disk_name = env('DISK');
                $disk = Storage::disk($disk_name);
                if ($disk_name == 'gcs') {
                    $disk->putFileAs($destination_path, $request->file('image'), $picName, 'public');
                } else {
                    $request->file('image')->move($destination_path, $picName);

                };
                $user->update(['image' => $destination_path . '/' . $picName]);
                if($request->has('name')) {
                    $user->update(['name' => $request->input('name')]);
                }
                if($request->has('phone_no')) {
                    $user->update(['phone_no' => $request->input('phone_no')]);
                }
                return response()->json($user);
            }
        }
        else
        {
            if($request->has('name')) {
                $user->update(['name' => $request->input('name')]);
            }
            if($request->has('phone_no')) {
                $user->update(['phone_no' => $request->input('phone_no')]);
            }
        }
    }
}
