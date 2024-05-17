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

    public function getAllTroebelheid(Request $request)
    {
        $items = AquariumData::where('Troebelheid', '>', 0)->get(['Troebelheid']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No turbidity values found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }


    public function getLatestTroebelheid(Request $request)
    {
        $latestTurbidity = AquariumData::where('Troebelheid', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['Troebelheid']);

        if (!$latestTurbidity) {
            return response()->json([
                'status' => 'error',
                'message' => 'No turbidity value found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestTurbidity
        ]);
    }

    public function getAllStroming(Request $request)
    {
        $items = AquariumData::where('Stroming', '>', 0)->get(['Stroming']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No current values found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestStroming(Request $request)
    {
        $latestCurrent = AquariumData::where('Stroming', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['Stroming']);

        if (!$latestCurrent) {
            return response()->json([
                'status' => 'error',
                'message' => 'No current value found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestCurrent
        ]);
    }

    public function getAllWaterLevel(Request $request)
    {
        $items = AquariumData::where('Waterlevel', '>', 0)->get(['Waterlevel']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No water level values found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestWaterLevel(Request $request)
    {
        $latestWaterLevel = AquariumData::where('Waterlevel', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['Waterlevel']);

        if (!$latestWaterLevel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No water level found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestWaterLevel
        ]);
    }
}
