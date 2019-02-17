<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['name','symbol','slug','circulating_supply','total_supply','max_supply','date_added','num_market_pairs','cmc_rank'];

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

}
