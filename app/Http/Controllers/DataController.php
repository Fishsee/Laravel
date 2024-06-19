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

    public function processAndRetrieveData($id)
    {
        try {
            // Fetch the 12 newest records from the database using AquariumData model
            $aquariumData = AquariumData::where('aquarium_id', $id)
                ->orderBy('created_at', 'asc') // Order by ascending to get oldest records first
                ->take(12)
                ->get();

            if ($aquariumData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            // Extract data for acidity, turbidity, flow, and waterlevel from the collection
            $acidity = $aquariumData->pluck('phValue')->toArray();
            $turbidity = $aquariumData->pluck('turbidity')->toArray();
            $flow = $aquariumData->pluck('flow_rate')->toArray();
            $waterlevel = $aquariumData->pluck('water_level')->toArray();
            $temperature = $aquariumData->pluck('tempC')->toArray();
            $ip = $aquariumData->pluck('ip')->toArray();
            $data = [
                'acidity' => $acidity,
                'turbidity' => $turbidity,
                'flow' => $flow,
                'waterlevel' => $waterlevel,
                'temperature' => $temperature,
                'ip' => $ip,
            ];

            // Prepare data and thresholds for processing
            $dataForProcessingSend = [
                'data' => $data,
                'thresholds' => [
                    'acidity' => ['low' => 6.5, 'high' => 7.5],
                    'turbidity' => 60,
                    'flow' => 50,
                    'waterlevel' => ['low' => 80, 'high' => 95],
                    'temperature' => ['low' => 5, 'high' => 50],
                ]
            ];

            // Define the file name based on the provided ID
            $fileName = "aquarium_data_{$id}.json";
            
            // Write data to the specified JSON file
            $filePath = storage_path("$fileName");
            file_put_contents($filePath, json_encode($dataForProcessingSend));

            // Call the processData function
            $processedData = $this->processData($id);

            // Return the file path and processed data
            return response()->json([
                'file_path' => $filePath,
                'processed_data' => $processedData
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in processAndRetrieveData: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to process data'], 500);
        }
    }

    public function processData($id)
{
    try {
        // Specify the path to your Python script
        $pythonScriptPath = base_path("calculations/calculations.py");
        
        // Execute the Python script with the provided ID
        $command = escapeshellcmd("python $pythonScriptPath $id");
        $output = shell_exec($command);
        
        // Check if the output contains an error
        $decodedOutput = json_decode($output, true);

        if (isset($decodedOutput['error'])) {
            // Log the error
            Log::error('Python script error: ' . $decodedOutput['error']);
            return ['error' => $decodedOutput['error']];
        }

        // Write the predicted values to a JSON file
        $predictedValuesFile = "predicted_values_$id.json";
        $predictedValuesPath = storage_path($predictedValuesFile);
        file_put_contents($predictedValuesPath, $output);

        // Read the content of the JSON file
        $predictedValues = json_decode(file_get_contents($predictedValuesPath), true);

        // Return the contents of the JSON file
        return $predictedValues;
    } catch (\Exception $e) {
        Log::error('Exception in processData: ' . $e->getMessage());
        return ['error' => 'Error processing data'];
    }
}
}