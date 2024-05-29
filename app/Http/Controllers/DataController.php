<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveData;

class DataController extends Controller
{

    public function getData()
    {
        $latestData = LiveData::latest()->first();

        return response()->json($latestData);
    }

    // Method for the POST request
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
        ]);

        $latestData = LiveData::create($validatedData);

        return response()->json($latestData);
    }
}
