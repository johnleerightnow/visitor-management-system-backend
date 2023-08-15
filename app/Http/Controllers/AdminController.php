<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        // Hash the password using Laravel's built-in bcrypt (or argon2 depending on config)
        $hashedPassword = Hash::make($request->password);

        // Store the hashed password in the database.
        DB::table('admin')->insert([
            'email' => $request->email,
            'given_name' => $request->given_name,
            'last_name' => $request->last_name,
            'password' => $hashedPassword
        ]);

        return response()->json(['message' => 'User created successfully!'], 201);
    }

    public function adminlogin(Request $request)
    {
        // Validate the incoming request data first
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Authenticate the user
        $user = DB::table('admin')->where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        $customClaims = [
            'email' => $user->email,
            'given_name' => $user->given_name,
            'last_name' => $user->last_name,
            'sub' => $user->id, // sub claim is typically the user id and is required by JWT specification
            'iss' => env('APP_URL', 'http://localhost:8000'), // The issuer, typically the application URL
            'iat' => now()->timestamp, // Issued at timestamp
            'exp' => now()->addMinutes(config('jwt.ttl'))->timestamp // Expiry timestamp
        ];
    
        $payload = JWTFactory::customClaims($customClaims)->make();
        $token = JWTAuth::encode($payload);
    
        return response()->json(['token' => $token->get()]);
    }
}
