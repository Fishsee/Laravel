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
            case 'togglePump':
                $response['pump'] = $this->togglePump();
                break;
            default:
                $response['error'] = 'Unknown action';
                break;
        }

        return response()->json($response);
    }

    /**
     * Toggles the light on or off based on the current light level.
     *
     * @return int|null Returns the new light level or null if no data available.
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
        return 'ph';
    }

    /**
     * Simulates dropping food into the aquarium.
     *
     * @return string Indicates the action taken.
     */
    protected function dropFood()
    {
        return 'food';
    }

    /**
     * Toggles the pump state.
     *
     * @return bool Returns the new pump state.
     */
    protected function togglePump()
    {
        // Attempt to find the record with ID 1
        $aquarium = Aquarium::find(1);

        if (!$aquarium) {
            // If the aquarium does not exist, handle this case appropriately (maybe log an error or throw an exception)
            return false; // Or handle it in another way that fits your application
        }

        // Toggle the pump state
        $newState = !$aquarium->pump_state;
        $aquarium->pump_state = $newState;
        $aquarium->save();

        return $newState;
    }

}
