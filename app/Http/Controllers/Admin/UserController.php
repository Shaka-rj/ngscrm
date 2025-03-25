<?php

namespace App\Http\Controllers\Admin;

use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\User;


class UserController extends Controller
{
    public function index(){
        return redirect()->route('admin.user.requests');
    }

    // Surov qoldirganlar ruyxati
    public function requests(){
        $users = User::where('role', 1)->with('region')->get();

        $type = 1;
        return view('admin.user_requests', compact('users', 'type'));
    }

    // Agent sifatida qabul qilish
    public function confirm_agent(string $id){
        $user = User::find($id);
        $user->update(['role' => User::ROLE_AGENT]);

        Telegram::sendMessage([
            'chat_id' => $user['chat_id'],
            'text' => "Tibbiy vakillikka qabul qilindingiz"
        ]);

        return redirect()->route('admin.user.requests');
    }

    // Menejer sifatida qabul qilishda hududlarni ko'rsatish (step-1)
    public function confirm_manager_regions(string $id){
        $user = User::find($id);
        $regions = Region::all();

        $type = 2;
        return view('admin.user_requests', compact('user', 'type', 'regions'));
    }

    // Menejer sifatida qabul qilish (step-2)
    public function confirm_manager(Request $request, string $id){
        $user = User::find($id);
        $selectedRegions = $request->input('regions', []);

        $user->update([
            'role' => User::ROLE_MANAGER,
            'additional' => json_encode($selectedRegions)
        ]);

        Telegram::sendMessage([
            'chat_id' => $user['chat_id'],
            'text' => "Menejerlikka qabul qilindingiz"
        ]);
    }
    
    // Userni bekor qilish
    public function cancel_user(string $id){
        $user = User::find($id);
    
        if ($user) {
            $user->forceDelete();
        }
        
        return redirect()->route('admin.user.requests');
    }
}
