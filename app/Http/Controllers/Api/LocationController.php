<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Carbon\Carbon;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\User;

class LocationController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'type'      => 'required|in:district,object,doctor,pharmacy',
            'type_id'   => 'required|numeric',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = User::find($request->user_id);

        $tenMinutesAgo = Carbon::now()->subMinutes(10);

        $existingLocation = Location::where('type', $request->type)
            ->where('type_id', $request->type_id)
            ->latest()
            ->first();

        if ($existingLocation && $existingLocation->created_at > $tenMinutesAgo) {
            $timeDiff = Carbon::now()->diffInMinutes($existingLocation->created_at);
            $remainingMinutes = intval(10 - $timeDiff);
            
            Telegram::sendMessage([
                'chat_id' => $user->chat_id,
                'text' => "$remainingMinutes daqiqadan keyin lokaysiya junata olasiz"
            ]);

            return response()->json([
                'status' => 1,
                'data' => $existingLocation
            ], 200);
        }

        $location = Location::create($validated);

        Telegram::sendMessage([
            'chat_id' => $user->chat_id,
            'text' => "Lokatsiya saqlandi"
        ]);

        return response()->json([
            'status' => 2,
            'location' => $location
        ], 201);
    }
}
