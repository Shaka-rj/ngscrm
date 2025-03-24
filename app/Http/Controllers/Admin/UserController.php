<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){

    }

    public function requests(){
        $users = User::where('role', 1)->with('region')->get();

        return view('admin.user_requests', compact('users'));
    }
}
