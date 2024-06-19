<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BrightnessController extends Controller
{
    public function setBrightness(Request $request)
    {
        $request->validate([
            'brightness' => 'required|integer|min:0|max:100',
        ]);

        $brightness = $request->input('brightness');

        // Send the brightness to the Arduino
        $response = Http::post('http://your-arduino-ip/set-brightness', [
            'brightness' => $brightness,
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Brightness set successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to set brightness'], 500);
        }
    }
}
