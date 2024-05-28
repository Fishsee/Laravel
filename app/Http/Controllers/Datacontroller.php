namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function receiveData(Request $request)
    {
        $sensorValue = $request->input('sensor_value');

        // Doe hier iets met de ontvangen sensorwaarde, bijvoorbeeld opslaan in de database

        return response()->json(['message' => 'Data received successfully'], 200);
    }
}

