<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Quote extends Model
{
    protected $fillable = ['name','symbol','slug','circulating_supply','total_supply','max_supply','date_added','num_market_pairs','cmc_rank'];

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

    public function setDateAddedAttribute($value)
    {
        $this->attributes['date_added'] =  Carbon::parse($value);
    }

}
