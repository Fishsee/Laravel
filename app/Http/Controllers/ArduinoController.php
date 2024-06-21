<?php

namespace App\Http\Controllers;

use App\Models\AquariumData;
use Illuminate\Http\Response;

class ArduinoController extends Controller
{
    /**
     * Adjust the aquarium lights' brightness based on the light level and return a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleLight()
    {
        $latestData = AquariumData::latest()->first();

        if ($latestData) {
            if ($latestData->light_level <= 100) {
                // Logic to set brightness to 100
                return response()->json(['brightness' => 100]);
            } else {
                // Logic to set brightness to 0
                return response()->json(['brightness' => 0]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data available.'
            ], Response::HTTP_NOT_FOUND);  // HTTP 404
        }
    }
}
