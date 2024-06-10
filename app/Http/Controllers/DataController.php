<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AquariumData;

class DataController extends Controller
{
    public function postData(Request $request)
    {
        $validatedData = $request->validate([
            'tempC' => 'required|numeric',
            'distance_cm' => 'required|numeric',
            'light_level' => 'required|numeric',
            'water_level' => 'required|numeric',
            'flow_rate' => 'required|numeric',
            'phValue' => 'required|numeric',
            'turbidity' => 'required|numeric',
            'aquarium_id' => 'required|integer',
        ]);

        $latestData = AquariumData::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Data successfully recorded.',
            'data' => $latestData
        ]);
    }
}
