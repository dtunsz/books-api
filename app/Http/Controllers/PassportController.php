<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use League\Flysystem\Exception;

class PassportController extends Controller
{
    //

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('BookResourceBackend')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // try {
        //     //code...
        //     if (auth()->attempt($credentials)) {
        //         $token = auth()->user()->createToken('BookResourceBackend')->accessToken;
        //         return response()->json(['token' => $token], 200);
        //     }
        // } catch (Exception $e) {
        //     //throw $th;
        //     return new JsonResponse($e, 422);
        // }
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('BookResourceBackend')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 422);
        }
    }

    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    
}
