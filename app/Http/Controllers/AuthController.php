<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signupUser()
    {
        $request = request()->all();
        $validator = Validator::make($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'error','errors'=>$validator->errors()],422);
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request);
        if (!empty($user)) {
            return response()->json(['status'=>'success','msg'=>'User has been created successfully, Please login and continue.'],200);
        } else {
            return response()->json(['status'=>'success','errors'=>'User has not been created.'],422);
        }

    }
    public function loginUser()
    {
        $request = request()->all();
        $validator = Validator::make($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'error','errors'=>'Please type login password.!'],422);
        }
        if (auth()->attempt([
            'email'       => $request['email'],
            'password'    => $request['password']
        ])) {
            return response()->json(['status' => 'success'], 200);
        }
        return response()->json(['status' => 'error','msg' => 'Password does not match.!'], 200);
    }

    public function checkEmail()
    {
        if (!empty(request()->email)) {
            $hasValid = User::where(['email' => request()->email])->count();
            if (!empty($hasValid)) {
                return response()->json(['status'=>'success'],200);
            }
        }
        return response()->json(['status'=>'error', 'msg' => 'Please enter your valid Email.'],200);
    }

    public function logout()
    {
        auth()->guard()->logout();
        return redirect('/login');
    }
}
