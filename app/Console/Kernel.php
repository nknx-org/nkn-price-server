<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

use Carbon\Carbon;

use App\Quote;
use App\Price;

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
                //Query for USD and set up the main Quote
                $apiRequest = $client->Get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=NKN&convert=USD', $requestContent);
                $response = json_decode($apiRequest->getBody(),true);
                $quote = new Quote($response["data"]["NKN"]);
                $quote->save();

                $prices = [];
                $prices[] = new Price(array_merge($response["data"]["NKN"]["quote"]["USD"],["currency" => "USD"]));

                //Query for ETH
                $apiRequest = $client->Get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=NKN&convert=ETH', $requestContent);
                $response = json_decode($apiRequest->getBody(),true);
                $prices[] = new Price(array_merge($response["data"]["NKN"]["quote"]["ETH"],["currency" => "ETH"]));

                $quote->prices()->saveMany($prices);

            } catch (RequestException $re) {
                throw $re;
            }

        })->everyTenMinutes()->name('FetchCMCAPI');

        $schedule->call(function () {
            Quote::where('created_at', '<', Carbon::now()->subMonth(3))->delete();
            Price::where('created_at', '<', Carbon::now()->subMonth(3))->delete();
        })->monthly()->name('CleanUpPrices')->withoutOverlapping();
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
