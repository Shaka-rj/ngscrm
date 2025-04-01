<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\TurPlan;
use Carbon\Carbon;

class TurPlanController extends Controller
{
    public $user_id;

    public function __construct(){
        $this->user_id = auth()->user()->id;
    }

    public function index(){
        $currentDate = Carbon::now();

        if ($currentDate->day == 25) {
            $month = $currentDate->addMonth()->month;
        } else {
            $month = $currentDate->month;
        }

        $month_name = config('month.months')[$month];

        $list =$this->getturplans($month);

        return view('user.turplan', compact('month', 'month_name', 'list'));
    }

    public function edit($month_id){
        return view('user.turplanedit', [
            'list' => $this->getturplans($month_id),
            'api_token' => session('api_token'),
            'user_id' => $this->user_id,
            'month' => $month_id
        ]);
    }

    public function getturplans($month, $year = null){
        if (is_null($year)) $year = date('Y');

        $turplans = TurPlan::where('user_id', $this->user_id)->where('year', $year)->where('month', $month)->get();

        $turplan_amount = [];
        foreach ($turplans as $turplan){
            $turplan_amount[$turplan['pharmacy_id']] = $turplan['amount'];
        }

        $districts = District::with('pharmacies')->where('user_id', $this->user_id)->get();

        $list = [];
        foreach ($districts as $district){
            $list2 = [];
            $summ = 0;
            foreach ($district->pharmacies as $pharmacy){
                $id = $pharmacy->id;
                $amount = isset($turplan_amount[$id]) ? $turplan_amount[$id] : 0;
                $summ += $amount;
                $list2[] = ['name' => $pharmacy->name, 'id' => $id, 'amount' => $amount];
            }
            $list[] = ['name' => $district->name, 'amount' => $summ, 'pharmacies' => $list2];
        }

        return $list;
    }
}
