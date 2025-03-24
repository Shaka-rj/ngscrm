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

        $user = json_decode($req['user'], true);
        $user_id = $user['id'];

        session(['user_id' => $user_id]);

        //return redirect()->route('user.main.index');


        $bot_token = env('TELEGRAM_BOT_TOKEN');

        $check_hash = $req['hash'];

        $data_check_string = "auth_date=$req[auth_date]\nquery_id=$req[query_id]\nsignature=$req[signature]\nuser=$req[user]";

        $secret_key = hash_hmac('sha256', $bot_token, "WebAppData", true);
        $hash = bin2hex(hash_hmac('sha256', $data_check_string, $secret_key, true) );

        if(strcmp($hash, $check_hash) === 0){
            $tg_user = json_decode($req['user'], true);
            $chat_id = $tg_user['id'];
            dd('okokok');
        } else {
            dd('xatolik');
        }
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
