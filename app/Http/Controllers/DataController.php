<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\AquariumData;

class DataController extends Controller
{
    public function processAndRetrieveData($id)
    {
        // Fetch the 12 newest records from the database using AquariumData model
        $aquariumData = AquariumData::where('aquarium_id', $id)
            ->orderBy('created_at', 'asc') // Order by ascending to get oldest records first
            ->take(12)
            ->get();

        if ($aquariumData->isEmpty()) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        // Extract data for acidity, turbidity, flow, and waterlevel from the collection
        $acidity = $aquariumData->pluck('Acidity')->toArray();
        $turbidity = $aquariumData->pluck('Turbidity')->toArray();
        $flow = $aquariumData->pluck('Flow')->toArray();
        $waterlevel = $aquariumData->pluck('Waterlevel')->toArray();

        // Define the thresholds
        $thresholds = [
            'acidity' => ['low' => 6.5, 'high' => 7.5],
            'turbidity' => 60,
            'flow' => 50, // Example threshold for flow
            'waterlevel' => 50 // Example threshold for waterlevel
        ];

        // Prepare the response data
        $responseData = [
            'data' => [
                'acidity' => $acidity,
                'turbidity' => $turbidity,
                'flow' => $flow,
                'waterlevel' => $waterlevel
            ],
            'thresholds' => $thresholds
        ];

        return response()->json($responseData);
    }

    public function processData(Request $request)
    {
        $inputData = json_encode($request->input('data'));
        $thresholds = json_encode($request->input('thresholds'));
        
        $command = escapeshellcmd("python3 /calculations/calculations.py '$inputData' '$thresholds'");
        $output = shell_exec($command);

        return response()->json(json_decode($output, true));
    }
}
