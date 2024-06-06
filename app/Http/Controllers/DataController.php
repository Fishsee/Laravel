<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Aquarium;

class DataController extends Controller
{
    public function processAndRetrieveData($id)
    {
        // Fetch data from the database
        $data = Aquarium::find($id);

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        // Send data to the Python script
        $response = Http::post('http://fishsee.test/process-data', [
            'data' => $data
        ]);

        // Log a message to confirm that the data was sent
        Log::info('Data sent to the Python script for processing: ' . $data);

        // Get the JSON content of the response
        $responseData = $response->json();

        // Include the original data in the response body
        $responseData['original_data'] = $data;

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
