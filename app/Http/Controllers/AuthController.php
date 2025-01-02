<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $reqeust)
    {
        try{
            //validate incoming inputs
        $reqeust->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        //check matching user
        $user = User::where('email', $reqeust->email)->first();

        //check password
        if(!$user || ! Hash::check($reqeust->password, $user->password)){
            return response()->json(["error" => "email or password may be incorrect"]);
        }

        $token = $user->createToken($reqeust->email)->plainTextToken;
        return response()->json(["token" => $token],200);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 401);
        }
    }



    /**
     * register.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try{
            //validate incoming inputs
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'type'=>'user',
            'password'=>Hash::make($request->password),
        ]);
        if(!$user)
            return response()->json(["error" => "Error creating user"], 401);
        else
            return response()->json(["user" => $user], 201);
        }catch(Exception $e){
            return response()->json($e,401);
        }
    }
}
