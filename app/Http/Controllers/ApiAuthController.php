<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request){
        $rqUser = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
        ]);

        $user = User::create($rqUser);

        $token = $user->createToken($request->name);

        return [
            'user' => $user,
            'token' =>$token->plainTextToken,
        ]; 
    }


    public function login(Request $request){
        $rqUser = $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
    
        $user = User::where('email',$request->email)->first();
        // return $user;

        if(!$user || !Hash::check($request->password, $user->password)){
            return [
                'error' => 'error'
            ];
        }

    
        $token = $user->createToken($user->name);
        
        return [
            'user' => $user,
            'token' =>$token->plainTextToken,
        ]; 
    }
    public function logout(Request $request){
        // return 'ok';
        $request->user()->tokens()->delete();
        return ['logout'=>true];
    }
}
