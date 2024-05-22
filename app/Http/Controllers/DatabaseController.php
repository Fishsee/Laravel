<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function testConnection()
    {
        try {
            DB::connection()->getPdo();
            return "Database verbinding is succesvol tot stand gebracht.";
        } catch (\Exception $e) {
            return "Database verbinding is mislukt: " . $e->getMessage();
        }
    }
}
