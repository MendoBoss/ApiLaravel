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
            'email'=>'nullable',
            'password'=>'nullable',
        ]);
    
        $user = User::where('email',"user1@email.com")->first();
        // return $user;

        if(!$user || !Hash::check("12345678", $user->password)){
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
