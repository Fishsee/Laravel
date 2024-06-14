<?php

namespace App\Http\Controllers;

use App\Models\AquariumData;
use App\Models\FishType;
use Illuminate\Http\Request;

class AquariumController extends Controller
{
    public function checkConditions($aquariumId) {
        $latestData = AquariumData::where('aquarium_id', $aquariumId)->latest()->first();

        if (!$latestData) {
            return response()->json(['message' => 'Geen gegevens beschikbaar voor dit aquarium.'], 404);
        }

        $fishTypes = FishType::all();

        $results = [];

        foreach ($fishTypes as $fish) {
            $results[$fish->name] = [
                'Temperature OK' => $latestData->tempC >= $fish->temperature_min && $latestData->tempC <= $fish->temperature_max,
                'pH OK' => $latestData->phValue >= $fish->ph_min && $latestData->phValue <= $fish->ph_max,
                'Light Level OK' => $latestData->light_level >= $fish->lightlevel_min && $latestData->light_level <= $fish->lightlevel_max,
                'Water Level OK' => $latestData->water_level >= $fish->waterlevel_min && $latestData->water_level <= $fish->waterlevel_max,
                'Flow Rate OK' => $latestData->flow_rate >= $fish->flowrate_min && $latestData->flow_rate <= $fish->flowrate_max,
                'Turbidity OK' => $latestData->turbidity >= $fish->turbidity_min && $latestData->turbidity <= $fish->turbidity_max
            ];
        }

        return response()->json($results);
    }
}
