<?php

namespace App\Http\Controllers;

class DatabaseController extends Controller
{
    public function testConnection()
    {
        try {
            // Hier zou je normaal de databaseverbinding testen
            // Als de verbinding slaagt, retourneer "Hello, world!"
            return "Hello, world!";
        } catch (\Exception $e) {
            // Als er een fout optreedt, retourneer een foutbericht
            return "Error: " . $e->getMessage();
        }
    }
}
