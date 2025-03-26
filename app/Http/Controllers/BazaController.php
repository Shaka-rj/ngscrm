<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\District;
use App\Models\UserObject;
use App\Models\Doctor;
use App\Models\Pharmacy;

class BazaController extends Controller
{
    public $user_id;
    public $user;

    public function __construct(){
        $this->user_id = auth()->user()->id;
        $this->user = User::find($this->user_id);
    }

    public function district(){
        return view('user.baza', [
            'pagename' => 'Tumanlar',
            'page'     => 'district',
            'user'     => $this->user
        ]);
    }

    public function district_add(Request $request){
        $request->validate([
            'name' => 'required|min:1'
        ]);

        District::create([
            'user_id' => $this->user_id,
            'name' => $request->name,
            'region_id' => $this->user->region_id,
        ]);

        return redirect()->route('user.baza.district');
    }

    public function userobject(){
        return view('user.baza', [
            'pagename' => 'Obyektlar',
            'page'     => 'object',
            'districts' => District::with('userobjects')->where('user_id', $this->user_id)->get(),
            'user'     => $this->user
        ]);
    }

    public function userobject_add(Request $request){
        $request->validate([
            'district' => 'required|min:1',
            'name' => 'required|min:1'
        ]);

        UserObject::create([
            'user_id' => $this->user_id,
            'region_id' => $this->user->region_id,
            'district_id' => $request->district,
            'name' => $request->name
        ]);

        return redirect()->route('user.baza.object');
    }

    public function doctor(){
        $districts = District::with('userobjects')->where('user_id', $this->user_id)->get();

        $userobjects = [];
        foreach ($districts as $district) {
            foreach ($district->userobjects as $userobject) {
                $userobjects[$district->id][] = ['id' => $userobject->id, 'name' => $userobject->name];
            }
        }

        $userobjects_text = 'let objects = ' . json_encode($userobjects, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ';';

        return view('user.baza', [
            'pagename' => 'Shifokorlar',
            'page'     => 'doctor',
            'districts' => District::with('userobjects.doctors')->where('user_id', $this->user_id)->get(),
            'userobjects' => $userobjects_text,
            'user'     => $this->user
        ]);
    }

    public function doctor_add(Request $request){
        $request->validate([
            'district' => 'required|min:1',
            'object' => 'required|min:1',
            'firstname' => 'required|min:1|max:255',
            'lastname' => 'required|min:1|max:255',
        ]);

        Doctor::create([
            'user_id' => $this->user_id,
            'region_id' => $this->user->region_id,
            'district_id' => $request->district,
            'userobject_id' => $request->object,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname
        ]);

        return redirect()->route('user.baza.doctor');
    }

    public function pharmacy(){
        return view('user.baza', [
            'pagename' => 'Dorixonalar',
            'page'     => 'pharmacy',
            'districts' => District::with('pharmacies')->where('user_id', $this->user_id)->get(),
            'user'     => $this->user
        ]);
    }

    public function pharmacy_add(Request $request){
        $request->validate([
            'district' => 'required|min:1',
            'name' => 'required|min:1'
        ]);

        Pharmacy::create([
            'user_id' => $this->user_id,
            'region_id' => $this->user->region_id,
            'district_id' => $request->district,
            'name' => $request->name
        ]);

        return redirect()->route('user.baza.pharmacy');
    }
}
