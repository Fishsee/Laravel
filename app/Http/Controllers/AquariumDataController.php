<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AquariumData;

class AquariumDataController extends Controller
{
    public function getAllPH(Request $request)
    {
        $items = AquariumData::where('PH_Waarde', '>', 0)->get(['PH_Waarde']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No PH values found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }


    public function getLatestPH(Request $request)
    {
        $latestPH = AquariumData::where('PH_Waarde', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['PH_Waarde']);

        if (!$latestPH) {
            return response()->json([
                'status' => 'error',
                'message' => 'No PH value found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestPH
        ]);
    }
}
