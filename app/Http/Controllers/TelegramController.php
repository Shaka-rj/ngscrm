<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webapp(){
        $domain = config('app.url');
        return view('user.webapp', compact('domain'));
    }

    public function webapp_data(Request $request){
        $req = $request->all();
        dd($req);
        $user_id = $req['chat_id'];

        session(['user_id' => $user_id]);

        return 1;
    }

    public function webhook(Request $request)
    {
        $update = Telegram::commandsHandler(true);
        $message = $request->input('message.text');
        $chatId = $request->input('message.chat.id');

        if ($message) {
            if ($message == '/start'){
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Assalomu alaykum"
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function test(){
    // route get
    Telegram::sendMessage([
        'chat_id' => 111,
        'text' => "Hello Sir"
    ]);

    return response()->json(['status' => 'ok']);
    }
}
