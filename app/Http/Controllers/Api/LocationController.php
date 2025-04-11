<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Carbon\Carbon;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\User;
use App\Models\District;
use App\Models\UserObject;
use App\Models\Doctor;
use App\Models\Pharmacy;

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

        $type = $request->type;
        $type_id = $request->type_id;

        $user = User::find($request->user_id);

        $tenMinutesAgo = Carbon::now()->subMinutes(10);

        $existingLocation = Location::where('type', $type)
            ->where('type_id', $type_id)
            ->latest()
            ->first();

        if ($existingLocation && $existingLocation->created_at > $tenMinutesAgo) {
            $timeDiff = Carbon::now()->diffInMinutes($existingLocation->created_at);
            $remainingMinutes = intval(10 - $timeDiff);
            
            return response()->json([
                'status' => 1,
                'time' => $remainingMinutes
            ], 200);
        }

        $location = Location::create($validated);

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $user_txt = $user->name. ' '.$user->lastname."\nLokatsiya <a href='https://maps.google.com/maps?q=$latitude,$longitude&ll=$latitude,$longitude'>junatdi</a>\n";

        if ($type == 'district'){
            $r = District::find($type_id);
            $district = $r->name;
            $region = $r->region->name;
            $type_txt = "🏙Tumanga kelganlik\n$region->$district";
        } elseif ($type == 'object'){
            $r = UserObject::find($type_id);
            $objectname = $r->name;
            $district = $r->district->name;
            $region = $r->region->name;
            $type_txt = "🏢Obyektga kelganlik\n$region->$district->$objectname";
        } elseif ($type == 'doctor'){
            $r = Doctor::find($type_id);
            $doctor = $r->firstname.' '.$r->lastname;
            $objectname = $r->userObject->name;
            $district = $r->userObject->district->name;
            $region = $r->userObject->district->region->name;
            $type_txt = "👨‍⚕️Shifokorga kelganlik\n$region->$district->$objectname->$doctor";
        } elseif ($type == 'pharmacy'){
            $r = Pharmacy::find($type_id);
            $pharmacy = $r->name;
            $district = $r->district->name;
            $region = $r->district->region->name;
            $type_txt = "🏥Dorixonaga kelganlik\n$region->$district->$pharmacy";
        }


        Telegram::sendMessage([
            'chat_id' => env('EVENT_CHANNEL_ID'),
            'text' => $user_txt.$type_txt,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true
        ]);

        return response()->json([
            'status' => 2,
            'location' => $location
        ], 201);
    }
}
