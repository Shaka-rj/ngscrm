<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Plan;

class PlanController extends Controller
{
    public $user_id;

    public function __construct(){
        $this->user_id = auth()->user()->id;
    }

    public function index(){
        $today = Carbon::now()->toDateString();
        $yesterday = Carbon::now()->addDay()->toDateString();

        $date = Carbon::now()->hour >= 19 ? $yesterday : $today; 

        $plan = Plan::where('date_for', $date)->where('user_id', $this->user_id)->first();

        if ($plan){
            $content = str_replace("\n", "<hr>", $plan->content);
        } else {
            $content = '';
        }

        $plans = Plan::where('user_id', $this->user_id)
            ->orderBy('date_for', 'DESC')
            ->get()
            ->map(function ($plan){
                $plan->date_for = Carbon::parse($plan->date_for)->format('d.m.Y');
                return $plan;
            });
        
        $date = $this->todate($date);
        $yesterday = $this->todate($yesterday);

        $back_route = 'user.main.index';
        return view('user.plan', compact('content', 'date', 'plans', 'yesterday', 'back_route'));
    }

    public function show(string $date){
        $plan = Plan::where('date_for', $this->dateto($date))->where('user_id', $this->user_id)->first();

        if ($plan){
            $content = str_replace("\n", "<hr>", $plan->content);
        } else {
            $content = '';
        }

        $show = 1;

        $back_route = 'user.plan.index';
        return view('user.plan', compact('content', 'date', 'show', 'back_route'));
    }

    public function edit(string $date){
        $plan = Plan::where('date_for', $this->dateto($date))->where('user_id', $this->user_id)->first();

        if ($plan){
            $content = $plan->content;
        } else {
            $content = '';
        }

        $back_route = 'user.plan.index';
        return view('user.planedit', compact('content', 'date', 'back_route'));
    }

    public function update(Request $request, $date){
        $date = $this->dateto($date);

        if (!Carbon::createFromFormat('Y-m-d', $date)->isBefore(Carbon::today())) {
            $plan = Plan::updateOrCreate(
                [
                    'user_id'  => $this->user_id,
                    'date_for' => $date
                ],
                [
                    'content' => $request->input('content')
                ]
            );
        }

        return redirect()->route('user.plan.index');
    }

    private function todate($date){
        return Carbon::createFromFormat('Y-m-d', $date)->format('d.m.Y');
    }

    private function dateto($date){
        return Carbon::createFromFormat('d.m.Y', $date)->format('Y-m-d');
    }
}
