<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateAquariumData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:aquarium-data')->everyMinute();

        $schedule->call(function () {
            $aquariums = \App\Models\Aquarium::all();
            $client = new \GuzzleHttp\Client();

            foreach ($aquariums as $aquarium) {
                try {
                    $response = $client->request('GET', "https://fishsee.aeternaserver.net/api/aquarium/{$aquarium->id}/drop-ph-tablet");
                    \Log::info("Drop PH tablet for aquarium {$aquarium->id}", ['status' => $response->getStatusCode()]);
                } catch (\Exception $e) {
                    \Log::error("Failed to drop PH tablet for aquarium {$aquarium->id}", ['error' => $e->getMessage()]);
                }
            }
        })->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
