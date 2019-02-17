<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $requestContent = [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-CMC_PRO_API_KEY'=> config('cmcapi.cmc_api_key')
                ]
            ];
            try {
                $client = new GuzzleHttpClient();
                $apiRequest = $client->Get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=NKN&convert=USD', $requestContent);
                $response = json_decode($apiRequest->getBody());
                dd($response->data->NKN->quote);
                foreach($response["data"]["NKN"]["quote"] as $price){
                    dd($price);
                }
                dd($response);
            } catch (RequestException $re) {
                throw $re;
            }

        })->everyMinute()->name('FetchCMCAPI')->withoutOverlapping();
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
