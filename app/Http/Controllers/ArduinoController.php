<?php

namespace App\Http\Controllers;

use App\Models\AquariumData;
use Illuminate\Http\Response;

class ArduinoController extends Controller
{
    public function handleRequest($action)
    {
        $response = ['pH' => null, 'food' => null, 'brightness' => null];

        switch ($action) {
            case 'toggleLight':
                $response['brightness'] = $this->toggleLight();
                break;
            case 'dropPHTablet':
                $response['pH'] = $this->dropPHTablet();
                break;
            case 'dropFood':
                $response['food'] = $this->dropFood();
                break;
        }

        return response()->json($response);
    }

    protected function toggleLight()
    {
        $latestData = AquariumData::latest()->first();
        if ($latestData) {
            return $latestData->light_level <= 100 ? 100 : 0;
        }
        return null;
    }

    protected function dropPHTablet()
    {
        return 'ph';
    }

    protected function dropFood()
    {
        return 'food';
    }
}
