<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CheckInOutController extends Controller
{
    public function checkin(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure the user exists
        ]);

        $data['check_in_time'] = now(); // Set the current time as check-in time

        DB::table('checkinout')->insert($data);

        return response()->json(['message' => 'Checked in successfully!'], 201);
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure the user exists
        ]);

        // Get the last check-in record of this user that hasn't been checked out yet
        $record = DB::table('checkinout')
                    ->where('user_id', $data['user_id'])
                    ->whereNull('check_out_time')
                    ->latest('check_in_time')
                    ->first();

        if (!$record) {
            return response()->json(['message' => 'No active check-in found for this user.'], 404);
        }

        // Update the check-out time
        DB::table('checkinout')
            ->where('id', $record->id)
            ->update(['check_out_time' => now()]);

        return response()->json(['message' => 'Checked out successfully!'], 200);
    }
}
