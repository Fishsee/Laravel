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
    $data = [
        'acidity' => $acidity,
        'turbidity' => $turbidity,
        'flow' => $flow,
        'waterlevel' => $waterlevel,
    ];

    // Prepare data and thresholds for processing
    $dataForProcessing = [
        'data' => $data,
        'thresholds' => [
            'acidity' => ['low' => 6.5, 'high' => 7.5],
            'turbidity' => 60,
            'flow' => 50,
            'waterlevel' => ['low' => 80, 'high' => 95],
        ]
    ];

    // Call the processData function and get its response
    $processedData = $this->processData($dataForProcessing);

    // Return the processed data along with the original data in the response body
    return response()->json([
        'original_data' => $aquariumData->toArray(),
        'data_for_processing' => $dataForProcessing,
        'processed_data' => $processedData,
    ]);
}

public function processData($dataForProcessing)
{
    // Encode data and thresholds to JSON strings
    $inputData = json_encode($dataForProcessing['data']);
    $thresholds = json_encode(['thresholds' => $dataForProcessing['thresholds']]);

    // Execute the Python script with the provided data and thresholds
    $command = escapeshellcmd("python3 /calculations/calculations.py '$inputData' '$thresholds'");
    $output = shell_exec($command);

    // Decode the JSON output from the Python script
    $decodedOutput = json_decode($output, true);

    // Check if the output contains an error
    if (isset($decodedOutput['error'])) {
        // Log the error
        Log::error('Python script error: ' . $decodedOutput['error']);
    }

    return $decodedOutput;
}
}
