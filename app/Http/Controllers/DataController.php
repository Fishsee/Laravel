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
    // Fetch data from the database using AquariumData model
    $aquariumData = AquariumData::where('aquarium_id', $id)->first();

    if (!$aquariumData) {
        return response()->json(['error' => 'Data not found'], 404);
    }

    // Log a message to confirm that the data was sent
    Log::info('Data sent to the Python script for processing: ' . json_encode($aquariumData->toArray()));

    // Prepare the data to send to the Python script
    $requestData = [
        'data' => [
            'acidity' => json_decode($aquariumData->acidity),
            'turbidity' => json_decode($aquariumData->turbidity)
        ],
        'thresholds' => [
            'acidity' => ['low' => 6.5, 'high' => 7.5],
            'turbidity' => 60
        ]
    ];

    // Send data to the Python script
    $response = Http::post('http://fishsee.test/process-data', $requestData);

    // Get the JSON content of the response
    $responseData = $response->json();

    // Include the original data in the response body
    $responseData['original_data'] = $aquariumData;

    // Return the modified response
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
