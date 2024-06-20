<?php

namespace App\Http\Controllers;

use App\Models\LiveData;
use Illuminate\Http\Request;
use App\Models\AquariumData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AquariumDataController extends Controller
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
        ]);

        $latestData = AquariumData::create($validatedData);

        return response()->json($latestData);
    }

    public function getAllPH($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('phValue', '>', 0)
            ->get(['phValue']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No PH values found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestPH($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $latestPH = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('phValue', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['phValue']);

        if (!$latestPH) {
            return response()->json([
                'status' => 'error',
                'message' => 'No PH value found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestPH
        ]);
    }

    public static function getArduinoIp()
    {
        $latestData = AquariumData::latest()->first();
        return $latestData ? $latestData->ip : null;
    }

    public function getDailyAveragePH($aquarium_id, Request $request, $date = null)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('phValue', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averagePH = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(phValue) as average_ph'))
                ->groupBy('date')
                ->first();

            if (!$averagePH) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No pH values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averagePH
            ]);
        } else {
            $dailyAveragePH = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(phValue) as average_ph'))
                ->groupBy('date')
                ->get();

            if ($dailyAveragePH->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No pH values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAveragePH
            ]);
        }
    }


    public function getAllturbidity($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('turbidity', '>', 0)
            ->get(['turbidity']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No turbidity values found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestturbidity($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $latestTurbidity = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('turbidity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['turbidity']);

        if (!$latestTurbidity) {
            return response()->json([
                'status' => 'error',
                'message' => 'No turbidity value found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestTurbidity
        ]);
    }

    public function getDailyAverageturbidity($aquarium_id, Request $request, $date = null)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('turbidity', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averageturbidity = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(turbidity) as average_turbidity'))
                ->groupBy('date')
                ->first();

            if (!$averageturbidity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No turbidity values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averageturbidity
            ]);
        } else {
            $dailyAverageturbidity = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(turbidity) as average_turbidity'))
                ->groupBy('date')
                ->get();

            if ($dailyAverageturbidity->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No turbidity values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAverageturbidity
            ]);
        }
    }

    public function getAllflow_rate($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('flow_rate', '>', 0)
            ->get(['flow_rate']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No current values found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestflow_rate($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $latestCurrent = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('flow_rate', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['flow_rate']);

        if (!$latestCurrent) {
            return response()->json([
                'status' => 'error',
                'message' => 'No current value found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestCurrent
        ]);
    }

    public function getDailyAverageflow_rate($aquarium_id, Request $request, $date = null)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('flow_rate', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averageflow_rate = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(flow_rate) as average_flow_rate'))
                ->groupBy('date')
                ->first();

            if (!$averageflow_rate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No flow_rate values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averageflow_rate
            ]);
        } else {
            $dailyAverageflow_rate = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(flow_rate) as average_flow_rate'))
                ->groupBy('date')
                ->get();

            if ($dailyAverageflow_rate->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No flow_rate values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAverageflow_rate
            ]);
        }
    }

    public function getAllwater_level($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('water_level', '>', 0)
            ->get(['water_level']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No water level values found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestwater_level($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $latestwater_level = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('water_level', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['water_level']);

        if (!$latestwater_level) {
            return response()->json([
                'status' => 'error',
                'message' => 'No water level found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestwater_level
        ]);
    }

    public function getDailyAveragewater_level($aquarium_id, Request $request, $date = null)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('water_level', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averagewater_level = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(water_level) as average_water_level'))
                ->groupBy('date')
                ->first();

            if (!$averagewater_level) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No water level values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averagewater_level
            ]);
        } else {
            $dailyAveragewater_level = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(water_level) as average_water_level'))
                ->groupBy('date')
                ->get();

            if ($dailyAveragewater_level->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No water level values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAveragewater_level
            ]);
        }
    }

    public function getAllTemperatures($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('tempC', '>', 0)
            ->get(['tempC']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No temperature values found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestTemperature($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $latestTemperature = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('tempC', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['tempC']);

        if (!$latestTemperature) {
            return response()->json([
                'status' => 'error',
                'message' => 'No temperature value found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestTemperature
        ]);
    }

    public function getDailyAverageTemperature($aquarium_id, Request $request, $date = null)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('tempC', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averageTemperature = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(tempC) as average_temperature'))
                ->groupBy('date')
                ->first();

            if (!$averageTemperature) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No temperature values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averageTemperature
            ]);
        } else {
            $dailyAverageTemperature = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(tempC) as average_temperature'))
                ->groupBy('date')
                ->get();

            if ($dailyAverageTemperature->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No temperature values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAverageTemperature
            ]);
        }
    }

    public function getAllDistances($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('distance_cm', '>', 0)
            ->get(['distance_cm']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No distance values found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestDistance($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $latestDistance = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('distance_cm', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['distance_cm']);

        if (!$latestDistance) {
            return response()->json([
                'status' => 'error',
                'message' => 'No distance value found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestDistance
        ]);
    }

    public function getDailyAverageDistance($aquarium_id, Request $request, $date = null)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('distance_cm', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averageDistance = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(distance_cm) as average_distance'))
                ->groupBy('date')
                ->first();

            if (!$averageDistance) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No distance values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averageDistance
            ]);
        } else {
            $dailyAverageDistance = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(distance_cm) as average_distance'))
                ->groupBy('date')
                ->get();

            if ($dailyAverageDistance->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No distance values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAverageDistance
            ]);
        }
    }

    public function getAllLightLevels($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('light_level', '>', 0)
            ->get(['light_level']);

        if ($items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No light level values found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    public function getLatestLightLevel($aquarium_id, Request $request)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $latestLightLevel = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('light_level', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['light_level']);

        if (!$latestLightLevel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No light level value found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestLightLevel
        ]);
    }

    public function getDailyAverageLightLevel($aquarium_id, Request $request, $date = null)
    {
        $user = Auth::user();

        if (!$user->aquariums()->where('id', $aquarium_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('light_level', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averageLightLevel = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(light_level) as average_light_level'))
                ->groupBy('date')
                ->first();

            if (!$averageLightLevel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No light level values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averageLightLevel
            ]);
        } else {
            $dailyAverageLightLevel = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(light_level) as average_light_level'))
                ->groupBy('date')
                ->get();

            if ($dailyAverageLightLevel->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No light level values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAverageLightLevel
            ]);
        }
    }

    // Other methods...

    /**
     * Sets the brightness of the aquarium's light.
     *
     * @param int $brightness Level of brightness (0, 25, 50, 75, 100)
     * @return \Illuminate\Http\JsonResponse
     */
    public function setBrightness($brightness)
    {
        // Validate the brightness input
        if (!in_array($brightness, [0, 25, 50, 75, 100])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid brightness value. Allowed values are 0, 25, 50, 75, 100.'
            ], 400);
        }

        // Logic to send the brightness level to the hardware, e.g., an Arduino
        // This is a placeholder for the actual hardware interaction code
        // $result = $this->sendBrightnessToHardware($brightness);

        // Simulate a success response (replace this with actual result handling)
        return response()->json([
            'status' => 'success',
            'data' => [
                'brightness' => $brightness,
                'message' => 'Brightness level set successfully.'
            ]
        ]);
    }

    // Example method that would interface with hardware
    // protected function sendBrightnessToHardware($brightness)
    // {
    //     // Your code to communicate with the Arduino or other hardware
    //     // This could involve sending an HTTP request, using GPIO pins, etc.
    // }
}

