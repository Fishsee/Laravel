<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AquariumData;
use Illuminate\Support\Facades\DB;


class AquariumDataController extends Controller
{
    public function getAllPH($aquarium_id, Request $request)
    {
        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('PH_Waarde', '>', 0)
            ->get(['PH_Waarde']);

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
        $latestPH = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('PH_Waarde', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['PH_Waarde']);

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

    public function getDailyAveragePH($aquarium_id, Request $request, $date = null)
    {
        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('PH_Waarde', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averagePH = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(PH_Waarde) as average_ph'))
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
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(PH_Waarde) as average_ph'))
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

    public function getAllTroebelheid($aquarium_id, Request $request)
    {
        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Troebelheid', '>', 0)
            ->get(['Troebelheid']);

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

    public function getLatestTroebelheid($aquarium_id, Request $request)
    {
        $latestTurbidity = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Troebelheid', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['Troebelheid']);

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

    public function getDailyAverageTroebelheid($aquarium_id, Request $request, $date = null)
    {
        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Troebelheid', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averageTroebelheid = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(Troebelheid) as average_troebelheid'))
                ->groupBy('date')
                ->first();

            if (!$averageTroebelheid) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No troebelheid values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averageTroebelheid
            ]);
        } else {
            $dailyAverageTroebelheid = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(Troebelheid) as average_troebelheid'))
                ->groupBy('date')
                ->get();

            if ($dailyAverageTroebelheid->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No troebelheid values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAverageTroebelheid
            ]);
        }
    }

    public function getAllStroming($aquarium_id, Request $request)
    {
        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Stroming', '>', 0)
            ->get(['Stroming']);

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

    public function getLatestStroming($aquarium_id, Request $request)
    {
        $latestCurrent = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Stroming', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['Stroming']);

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

    public function getDailyAverageStroming($aquarium_id, Request $request, $date = null)
    {
        $query = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Stroming', '>', 0);

        if ($date) {
            $parsedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $parsedDate);

            $averageStroming = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(Stroming) as average_stroming'))
                ->groupBy('date')
                ->first();

            if (!$averageStroming) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No stroming values found for aquarium ID ' . $aquarium_id . ' on date ' . $parsedDate
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $averageStroming
            ]);
        } else {
            $dailyAverageStroming = $query
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(Stroming) as average_stroming'))
                ->groupBy('date')
                ->get();

            if ($dailyAverageStroming->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No stroming values found for aquarium ID ' . $aquarium_id
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $dailyAverageStroming
            ]);
        }
    }


    public function getAllWaterLevel($aquarium_id, Request $request)
    {
        $items = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Waterlevel', '>', 0)
            ->get(['Waterlevel']);

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

    public function getLatestWaterLevel($aquarium_id, Request $request)
    {
        $latestWaterLevel = AquariumData::where('aquarium_id', $aquarium_id)
            ->where('Waterlevel', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first(['Waterlevel']);

        if (!$latestWaterLevel) {
            return response()->json([
                'status' => 'error',
                'message' => 'No water level found for aquarium ID ' . $aquarium_id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $latestWaterLevel
        ]);
    }
}
