<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\AquariumData;

class PredictionDataController extends Controller
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
        $dataForProcessingSend = [
            'data' => $data,
            'thresholds' => [
                'acidity' => ['low' => 6.5, 'high' => 7.5],
                'turbidity' => 60,
                'flow' => 50,
                'waterlevel' => ['low' => 80, 'high' => 95],
            ]
        ];

        // Define the file name based on the provided ID
        $fileName = "aquarium_data_{$id}.json";

        // Write data to the specified JSON file
        $filePath = storage_path("{$fileName}");
        file_put_contents($filePath, json_encode($dataForProcessingSend));

        // Return the file path for Python script execution
        return ['file_path' => $filePath];
    }


    public function processData($filePath)
    {
        try {
            // Execute the Python script with the provided file path
            $command = escapeshellcmd("python $filePath $id");
            $output = shell_exec($command);

            // Log the command and output for debugging
            Log::info('Executing command: ' . $command);
            Log::info('Python script output: ' . $output);

            // Decode the JSON output from the Python script
            $decodedOutput = json_decode($output, true);

            // Check if the output contains an error
            if (isset($decodedOutput['error'])) {
                // Log the error
                Log::error('Python script error: ' . $decodedOutput['error']);
                return ['error' => $decodedOutput['error']];
            }

            return $decodedOutput; // Return processed data
        } catch (\Exception $e) {
            Log::error('Error processing data: ' . $e->getMessage());
            return ['error' => 'Error processing data'];
        }
    }


    public function testDataFunctions($id)
    {
        try {
            // Step 1: Retrieve and process the data
            $filePath = $this->processAndRetrieveData($id)['file_path'];

            // Step 2: Process the data using processData method
            $processedData = $this->processData($filePath);

            // Return both the file path and the processed data
            return response()->json([
                'file_path' => $filePath, // Returning file path for reference
                'processed_data' => $processedData
            ]);
        } catch (\Exception $e) {
            Log::error('Error in testDataFunctions: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to process data'], 500);
        }
    }
}

