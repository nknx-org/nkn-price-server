<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Quote;
use App\Price;

use DB;

class QuoteController extends Controller
{

    // Query current price of quote:
    // /price?quote=NKN&currency=USD,ETH

    // Query historical price of quote:
    // /history?quote=NKN&currency=USD,ETH&aggregate=days


    /**
	 * Get current prices of Quote
	 *
	 * Returns chosen quotes and the current prices of the chosen currency
	 *
     * @queryParam quote The symbols you want to get returned Example: NKN
     * @queryParam currency The currencies you want to get Example: USD,ETH
     *
	 */
    public function price(Request $request){
        $quotes = explode(',', $request->input('quote'));
        $currencies = explode(',', $request->input('currency'));

        if (!count($quotes) ) {
            return response([
                'status' => 'error',
                'error' => 'quote.empty',
                'msg' => 'quote not provided'
            ], 400);
        }
        if (!count($currencies) ) {
            return response([
                'status' => 'error',
                'error' => 'currency.empty',
                'msg' => 'currency not provided'
            ], 400);
        }

        $result = [];

        foreach ($quotes as $quote) {
            $query_result =
                Quote::where('symbol',$quote)
                ->with(array('prices' => function($query) use ($currencies){
                    $query->whereIn('currency', $currencies);
                }))
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->first();
            $result[] = $query_result;
        }
        return response()->json($result);
    }

    /**
	 * Get History of Quotes
	 *
	 * Returns chosen quotes and the history prices of the chosen currency based on the aggregation level
	 *
     * @queryParam quote The symbols you want to get returned Example: NKN
     * @queryParam currency The currencies you want to get Example: USD,ETH
     * @queryParam aggregate The currencies you want to get Example: days
     *
	 */
    public function history(Request $request){
        $quotes = explode(',', $request->input('quote'));
        $currencies = explode(',', $request->input('currency'));
        $aggregate = $request->input('aggregate');

        if (!count($quotes) ) {
            return response([
                'status' => 'error',
                'error' => 'quote.empty',
                'msg' => 'quote not provided'
            ], 400);
        }
        if (!count($currencies) ) {
            return response([
                'status' => 'error',
                'error' => 'currency.empty',
                'msg' => 'currency not provided'
            ], 400);
        }
        if (!$aggregate) {
            return response([
                'status' => 'error',
                'error' => 'aggregate.empty',
                'msg' => 'aggregation not provided'
            ], 400);
        }

        $result = [];

        foreach ($quotes as $quote) {
            $quote_object = [
                "symbol" => $quote
            ];

            foreach ($currencies as $currency) {
                $currencies_query = null;
                if($aggregate == 'days'){
                    $currencies_query = Price::select(DB::raw("AVG(price) as price, DATE(created_at) AS date"))
                    ->where('currency', $currency)
                    ->whereHas('quote', function($query) use ($quote){
                        return $query->where('symbol', $quote);
                    })
                    ->orderBy(DB::raw('DATE(created_at)'), 'desc')
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->limit(30)
                    ->get();
                }
                else if($aggregate == 'months'){
                    $currencies_query = Price::select(DB::raw("AVG(price) as price, MONTH(created_at) AS month"))
                    ->where('currency', $currency)
                    ->whereHas('quote', function($query) use ($quote){
                        return $query->where('symbol', $quote);
                    })
                    ->orderBy(DB::raw('MONTH(created_at)'), 'desc')
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();
                }
                else if($aggregate == 'weeks'){
                    $currencies_query = Price::select(DB::raw("AVG(price) as price, WEEK(created_at) AS week"))
                    ->where('currency', $currency)
                    ->whereHas('quote', function($query) use ($quote){
                        return $query->where('symbol', $quote);
                    })
                    ->orderBy(DB::raw('WEEK(created_at)'), 'desc')
                    ->groupBy(DB::raw('WEEK(created_at)'))
                    ->get();
                }
                if($currencies_query){
                    $quote_object[$currency]=$currencies_query;
                }


            }
            $result[] = $quote_object;
        }
        return response()->json($result);


    }
}
