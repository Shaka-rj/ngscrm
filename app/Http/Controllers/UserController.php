<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Region;


class UserController extends Controller
{
    public function test(){
        $user = User::find(1);
        Auth::login($user);
        session(['api_token' => $user->createToken('API Token')->plainTextToken]);

        return redirect()->route('user.main.index');
    }

    public function registration(){
        $chat_id = session('chat_id');
        $user = User::where('chat_id', $chat_id)->first();

        if (!$user) {
            $user = [
                'chat_id' => $chat_id,
                'isrequest' => false
            ];
        } else {
            $user = [
                'chat_id' => $chat_id,
                'isrequest' => true
            ];
        }

        $regions = Region::all();

        return view('user.registration', compact('user', 'regions'));
    }

    public function registration_store(Request $request){
        $request->validate([
            'firstname' => 'required|string|min:2|max:100',
            'lastname' => 'required|string|min:2|max:100',
            'region' => 'required|min:1'
        ]);

        $existingUser = User::where('chat_id', session('chat_id'))->first();

        if (!$existingUser) {
            User::create([
                'name' => $request->firstname,
                'lastname' => $request->lastname,
                'chat_id' => session('chat_id'),
                'region_id' => $request->region,
                'role' => 1
            ]);
        }

        return redirect()->route('registration');
    }
}
