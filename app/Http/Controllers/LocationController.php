<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\User;
use App\Models\District;
use App\Models\UserObject;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\Location;
use Carbon\Carbon;

class LocationController extends Controller
{
    public function __construct(){
        $this->user_id = auth()->user()->id;
        $this->user = User::find($this->user_id);
        $this->role = $this->user->role;

    }

    public function index(){
        $types = [
            Location::DISTRICT => "Tuman",
            Location::USEROBJECT => "Obyekt",
            Location::DOCTOR => "Shifokor",
            Location::PHARMACY => "Dorixona"
        ];

        $locations = Location::whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->with([
                'district',
                'userobject.district',
                'doctor.userObject.district',
                'pharmacy.district'
            ])
            ->orderByDesc('id')
            ->get();

        $locations_full = $locations->map(function ($location) {
            return [
                'type' => $location->type,
                'created_at' => $location->created_at->format('H:i d.m.y'),
                'district' => $location->type === 'district' ? optional($location->district)->name :
                              ($location->type === 'doctor' ? optional($location->doctor?->userObject?->district)->name :
                              ($location->type === 'object' ? optional($location->userobject?->district)->name : 
                                ($location->type === 'pharmacy' ? optional($location->pharmacy?->district)->name : ''))),
                'object' => $location->type === 'doctor' ? optional($location->doctor?->userObject)->name : 
                           ($location->type === 'object' ? optional($location->userobject)->name : ''),
                'doctor' => $location->type === 'doctor' ? optional($location->doctor)->firstname . ' ' . optional($location->doctor)->lastname : '',
                'pharmacy' => $location->type === 'pharmacy' ? optional($location->pharmacy)->name : '',
            ];
        });

        return view('user.location', [
            'locations' => $locations_full,
            'types' => $types
        ]);

    }

    public function district(){
        return view('user.locationselect', [
            'pagename' => 'Tumanni tanlang',
            'page'     => 'district',
            'user'     => $this->user,
            'api_token' => session('api_token')
        ]);
    }

    public function object(){
        return view('user.locationselect', [
            'pagename' => 'Obyektni tanlang',
            'page'     => 'object',
            'districts' => District::with('userobjects')->where('user_id', $this->user_id)->get(),
            'user'     => $this->user,
            'api_token' => session('api_token')
        ]);
    }

    public function doctor(){
        return view('user.locationselect', [
            'pagename' => 'Shifokorni tanlang',
            'page'     => 'doctor',
            'districts' => District::with('userobjects.doctors')->where('user_id', $this->user_id)->get(),
            'user'     => $this->user,
            'api_token' => session('api_token')
        ]);
    }

    public function pharmacy(){
        return view('user.locationselect', [
            'pagename'  => 'Dorixonani tanlang',
            'page'      => 'pharmacy',
            'districts' => District::with('pharmacies')->where('user_id', $this->user_id)->get(),
            'user'      => $this->user,
            'api_token' => session('api_token')
        ]);
    }
}
