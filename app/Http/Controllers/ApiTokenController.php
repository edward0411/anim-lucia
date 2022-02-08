<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    
    public function login(Request $request)
    {

        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        //dd($username);

        if (!Auth::attempt(['email' => $username, 'password' => $password])) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();
        
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
    

}