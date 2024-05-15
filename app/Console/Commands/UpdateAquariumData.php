<?php
use Illuminate\Console\Command;

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
    protected $description = 'Update aquarium data every 10 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Generate random values for JSON data
        $jsonData = [
            'PH-Waarde' => rand(1, 14), // Random pH value between 1 and 14
            'Troebelheid' => rand(0, 100), // Random troebelheid value between 0 and 100
            'Stroming' => rand(0, 100), // Random stroming value between 0 and 100
            'Waterlevel' => rand(0, 100), // Random waterlevel value between 0 and 100
        ];

        // Update the existing record in the database
        \DB::table('aquarium_data')->update([
            'json_data' => json_encode($jsonData, JSON_UNESCAPED_UNICODE)
        ]);

        $this->info('Aquarium data updated successfully.');

        return 0;
    }
}

