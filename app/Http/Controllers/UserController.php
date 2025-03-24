<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
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

        return view('user.registration', compact('user'));
    }

    public function registration_store(Request $request){
        // $validated = $request->validate([

        // ]);

        dd($request->all());
    }
}
