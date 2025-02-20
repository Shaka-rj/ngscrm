<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Spets;

class SpetsController extends Controller
{
    public function show($id) {
        $spets = Spets::findOrFail($id);
    
        dd($spets);
    }

    public function create(){
        $products = Product::all();
        
        return view('user.spets_form', compact('products'));
    }

    public function store(Request $request)
    {
        $details = [];
        $req = $request->all();

        foreach ($req as $k => $v){
            if (substr($k, 0, 1) == 's'){
                $details[substr($k, 1)]['count'] = $v;
            } elseif (substr($k, 0, 2) == 'id'){
                $details[substr($k, 2)]['id'] = $v;
            }
        }

        if (is_null($req['customer'])){
            $req['customer'] = '';
        }
        $spets = Spets::create([
            'company' => $req['company'],
            'customer' => $req['customer'],
            'summ' => 11111,
            'details' => $details
        ]);

        return redirect()->route('user.spets.show', $spets->id)->with('success', 'Spets muvaffaqiyatli yaratildi!');
    }
}
