<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aquarium;

class DataController extends Controller
{
    public function getDataInChunks()
    {
        $data = [];
        Aquarium::chunk(100, function ($items) use (&$data) {
            foreach ($items as $item) {
                $data[] = $item;
            }
        });

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $predictedValues = $request->all();

        foreach ($predictedValues as $factor => $values)
        {
            foreach ($values as $index => $value)
            {
                \Log::info("Predicted value for $factor at index $index: $value");
            }
        }

        return response()->json(['message' => 'predicted values received and processed correctly']);
    }
}
