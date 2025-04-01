<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TurPlan;

class TurPlanController extends Controller
{
    public function update(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'month' => 'required|integer',
            'data' => 'required|array'
        ]);


        foreach ($request->data as $item) {
            if (!isset($item['pharmacy_id']) || !isset($item['value'])) continue;

            $value = (int) str_replace(',', '', $item['value']);

            Turplan::updateOrCreate(
                [
                    'user_id' => $validated['user_id'],
                    'pharmacy_id' => $item['pharmacy_id'],
                    'month' => $validated['month'],
                    'year' => date('Y')
                ],
                [
                    'amount' => $value
                ]
            );
        }

        return response()->json([
            'status' => json_encode($request->all())
        ], 200);
    }
}
