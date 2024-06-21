<?php

namespace App\Http\Controllers;

use App\Models\Aquarium;
use Illuminate\Http\Response;

class ArduinoController extends Controller
{
    /**
     * Handle requests for Arduino actions.
     *
     * @param string $action The action to be performed.
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleRequest($action)
    {
        $response = ['brightness' => null, 'pH' => null, 'food' => null, 'pump' => null];

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
            case 'togglePump':
                $response['pump'] = $this->togglePump();
                break;
            default:
                return response()->json(['error' => 'Unknown action'], 400);
        }

        return response()->json($response);
    }

    /**
     * Toggles the light on or off based on the current light level.
     *
     * @return int Returns the new light level (100 if turned on, 0 if turned off).
     */
    protected function toggleLight()
    {
        $latestData = Aquaria::latest()->first();
        if ($latestData) {
            return $latestData->light_level <= 100 ? 100 : 0;
        }
        return null;
    }

    /**
     * Simulates dropping a pH tablet into the aquarium.
     *
     * @return string Indicates the action taken.
     */
    protected function dropPHTablet()
    {
        return 'ph'; // Simple static return for simulation purposes
    }

    /**
     * Simulates dropping food into the aquarium.
     *
     * @return string Indicates the action taken.
     */
    protected function dropFood()
    {
        return 'food'; // Simple static return for simulation purposes
    }

    /**
     * Toggles the pump state.
     *
     * @return bool Returns the new pump state (true or false).
     */
    protected function togglePump()
    {
        $aquarium = Aquarium::find(1); // Assume there's always an Aquarium with ID 1 for simplicity

        if ($aquarium) {
            $aquarium->pump_state = !$aquarium->pump_state; // Toggle the state
            $aquarium->save();
            return $aquarium->pump_state;
        }
        return false; // Default return if no aquarium is found
    }
}
