<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    // Methode voor de GET-aanvraag
    public function getData()
    {
        return response()->json(['message' => 'Hello, this is your data!']);
    }

    // Methode voor de POST-aanvraag
    public function postData(Request $request)
    {
        // Hier zou je normaal gesproken de data verwerken
        $data = $request->all();
        return response()->json(['received' => $data]);
    }
}

