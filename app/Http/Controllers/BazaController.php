<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Region;
use App\Models\User;
use App\Models\District;
use App\Models\UserObject;
use App\Models\Doctor;
use App\Models\Pharmacy;

class BazaController extends Controller
{
    public $user_id;
    public $user;
    public $role;

    // for manager
    public $users;

    public function __construct(){
        $this->user_id = auth()->user()->id;
        $this->user = User::find($this->user_id);
        $this->role = $this->user->role;

        if ($this->role == User::ROLE_MANAGER)
        {
            $regionIds = json_decode($this->user->additional, true);

            $this->users = Region::whereIn('id', $regionIds)
                    ->with(['users' => function ($query) {
                        $query->where('role', User::ROLE_AGENT)->orderBy('name', 'asc');
                    }])
                    ->orderBy('name', 'asc')->get();
        }
    }

    public function district(string $id = null){

        if ($this->role == User::ROLE_AGENT)
            return view('user.baza', [
                'pagename' => 'Tumanlar',
                'page'     => 'district',
                'user'     => $this->user
            ]);
        elseif ($this->role == User::ROLE_MANAGER)
            if ($id === null)
                return view('user.bazamanager', [
                    'pagename' => "Tumanini ko'rmoqchi bo'lgan agentni tanlang",
                    'page'     => 'selectuser',
                    'type'     => 'district',
                    'users'    => $this->users
                ]);
            else
                return view('user.bazamanager', [
                    'pagename' => 'Tumanlar',
                    'page'     => 'district',
                    'user'     => User::find($id)
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

    public function userobject(string $id = null){
        if ($this->role == User::ROLE_AGENT)
            return view('user.baza', [
                'pagename' => 'Obyektlar',
                'page'     => 'object',
                'districts' => District::with('userobjects')->where('user_id', $this->user_id)->get(),
                'user'     => $this->user
            ]);
        elseif ($this->role == User::ROLE_MANAGER)
            if ($id === null)
                return view('user.bazamanager', [
                    'pagename' => "Obyektini ko'rmoqchi bo'lgan agentni tanlang",
                    'page'     => 'selectuser',
                    'type'     => 'object',
                    'users'    => $this->users
                ]);
            else
                return view('user.bazamanager', [
                    'pagename'  => 'Obyektlar',
                    'page'      => 'object',
                    'districts' => District::with('userobjects')->where('user_id', $id)->get(),
                    'user'      => User::find($id)
                ]);
    }

    public function userobject_add(Request $request){
        $request->validate([
            'district' => 'required|integer|min:1|not_in:0',
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

    public function doctor(string $id = null){
        if ($this->role == User::ROLE_AGENT)
        {
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
        elseif ($this->role == User::ROLE_MANAGER)
            if ($id === null)
                return view('user.bazamanager', [
                    'pagename' => "Shifokorlarini ko'rmoqchi bo'lgan agentni tanlang",
                    'page'     => 'selectuser',
                    'type'     => 'doctor',
                    'users'    => $this->users
                ]);
            else
                return view('user.bazamanager', [
                    'pagename'  => 'Shifokorlar',
                    'page'      => 'doctor',
                    'districts' => District::with('userobjects.doctors')->where('user_id', $id)->get(),
                    'user'      => User::find($id)
                ]);
    }

    public function doctor_add(Request $request){
        $request->validate([
            'district' => 'required|integer|min:1|not_in:0',
            'object' => 'required|integer|min:1|not_in:0',
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

    public function pharmacy(string $id = null){
        if ($this->role == User::ROLE_AGENT)
            return view('user.baza', [
                'pagename' => 'Dorixonalar',
                'page'     => 'pharmacy',
                'districts' => District::with('pharmacies')->where('user_id', $this->user_id)->get(),
                'user'     => $this->user
            ]);
        elseif ($this->role == User::ROLE_MANAGER)
            if ($id === null)
                return view('user.bazamanager', [
                    'pagename' => "Dorixonasini ko'rmoqchi bo'lgan agentni tanlang",
                    'page'     => 'selectuser',
                    'type'     => 'pharmacy',
                    'users'    => $this->users
                ]);
            else
                return view('user.bazamanager', [
                    'pagename'  => 'Dorixonalar',
                    'page'      => 'pharmacy',
                    'districts' => District::with('pharmacies')->where('user_id', $id)->get(),
                    'user'      => User::find($id)
                ]);
    }

    public function pharmacy_add(Request $request){
        $request->validate([
            'district' => 'required|integer|min:1|not_in:0',
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
