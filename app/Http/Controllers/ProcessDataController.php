<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessDataController extends Controller
{
    public function processData(request $request)
    {
        $data = $request->input('data');

        $process = new Process(['python3', 'calculations/calculations.py', json_encode($data)]);
        $process->run();

        if (!$process->isSuccessful())
        {
            throw new ProcessFailedException($process);
        }

        $output = json_decode($process->getOutput(), true);
        return response()->json($output);
    }
}
