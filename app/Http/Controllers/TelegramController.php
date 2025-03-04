<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $update = Telegram::commandsHandler(true);
        $message = $request->input('message.text');
        $chatId = $request->input('message.chat.id');

        if ($message) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Siz yozdingiz: " . $message
            ]);
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
