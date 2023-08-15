<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users',
            'mobile' => 'required',
            'full_name' => 'required',
            'vehicle' => 'nullable',
            'walk_in' => 'nullable|boolean',
            'purpose' => 'required'
        ]);

        $user = DB::table('users')->insert($data);

        return response()->json(['message' => 'User registered successfully!'], 201);
    }
}
