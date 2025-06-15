<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\UserObject;
use App\Models\Doctor;
use App\Models\Pharmacy;

class BazaController extends Controller
{
    public function district(string $id = null){
        if ($id == null){
            $users = User::with('region')->orderBy('name', 'asc')->get();
            return view('admin.user_baza', [
                'users' => $users
            ]);
        } else {

        }
    }

    public function userobject(string $id = null){
        if ($id == null){

        } else {
            
        }
    }

    public function doctor(string $id = null){
        if ($id == null){

        } else {
            
        }
    }

    public function pharmacy(string $id = null){
        if ($id == null){

        } else {
            
        }
    }

    public function edit(string $type, string $id){
        if       ($type == 'district'){

        } elseif ($type == 'object'){

        } elseif ($type == 'doctor'){

        } elseif ($type == 'pharmacy'){

        }
    }

    public function update(string $type, string $id){
        if       ($type == 'district'){

        } elseif ($type == 'object'){

        } elseif ($type == 'doctor'){

        } elseif ($type == 'pharmacy'){

        }

    }

    public function delete(string $type, string $id){
        if       ($type == 'district'){

        } elseif ($type == 'object'){

        } elseif ($type == 'doctor'){

        } elseif ($type == 'pharmacy'){

        }
    }
}
