<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AquariumData;

class AquariumDataController extends Controller
{
    /**
     * Retrieve aquarium PH values and return them as a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPH(Request $request)
    {
        $items = AquariumData::where('PH_Waarde', '>', 0)->get(['PH_Waarde']);
        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }
}
