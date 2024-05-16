<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class UpdateAquariumData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:aquarium-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new aquarium data record every 10 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Generate random values and insert directly into columns
            DB::table('aquarium_data')->insert([
                'PH_Waarde' => $this->generateRandomPhValue(), // Random pH value between 1 and 14
                'Troebelheid' => rand(0, 100), // Random troebelheid value between 0 and 100
                'Stroming' => rand(0, 100), // Random stroming value between 0 and 100
                'Waterlevel' => rand(0, 100), // Random water level value between 0 and 100
                'created_at' => now(), // Ensure you have a timestamp for the creation
                'updated_at' => now()  // This might be optional depending on your table schema
            ]);
            $this->info('New aquarium data record created successfully.');
        } catch (Exception $e) {
            $this->error('Failed to insert data: ' . $e->getMessage());
            return 1; // Non-zero return code indicates failure
        }

        return 0; // Success
    }

    /**
     * Generate a random pH value between 1 and 14 with two decimal places
     *
     * @return float
     */
    protected function generateRandomPhValue()
    {
        return round(1 + mt_rand() / mt_getrandmax() * (14 - 1), 2);
    }
}
