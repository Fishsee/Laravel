<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function checkPH(Request $request)
    {
        // Your existing code to check pH value
        $jsonData = json_decode($request->getContent(), true);

        if (isset($jsonData['PH-Waarde']) && $jsonData['PH-Waarde'] > 8) {
            // pH value is higher than 8
            return response()->json(['message' => 'pH value is higher than 8'], 200);
        } else {
            // pH value is not higher than 8
            return response()->json(['message' => 'pH value is not higher than 8'], 200);
        }
    }
}

