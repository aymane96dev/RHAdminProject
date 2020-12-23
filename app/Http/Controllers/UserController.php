<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view',User::class);

        $nbr = User::withTrashed()
                ->where('deleted_at', null)
                ->count();
        
        $deleted_ones = User::onlyTrashed()
                ->count();
        return view('layouts.gestion.user',['nbr' => $nbr,'deleted_ones' => $deleted_ones]);
    }

    public function list()
    {
        $this->authorize('view',User::class);
        return UserResource::collection(User::paginate(5));
    }

    public function full()
    {
        $this->authorize('view',User::class);
        return UserResource::collection(User::all());
    }

    public function store(Request $request)
    {
        $this->authorize('view',User::class);
        $validator= Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:32'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' =>  ['required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $user=new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return new UserResource($user);

    }

    public function edit(Request $request)
    {
        $this->authorize('view',User::class);
        $validator= Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:32'],
            'role' =>  ['required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors; 
        }
        $user = User::find($request->input('id'));
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $this->authorize('view',User::class);
        $user = User::find($id);
        User::destroy($id);

        return new UserResource($user);
    }
}
