<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['currency','price','volume_24h','percent_change_1h','percent_change_24h','percent_change_7d','market_cap'];
    protected $casts = [
        'price' => 'float',
        'volume_24h' => 'float',
        'percent_change_1h' => 'float',
        'percent_change_24h' => 'float',
        'percent_change_7d' => 'float',
        'market_cap' => 'float'
    ];

    public function quote()
    {
        return $this->belongsTo('App\Quote');
    }
}
