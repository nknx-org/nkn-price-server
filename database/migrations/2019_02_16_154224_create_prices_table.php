<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency')->index();
            $table->float('price', 20, 8);
            $table->float('volume_24h', 20, 8);
            $table->float('percent_change_1h', 20, 8);
            $table->float('percent_change_24h', 20, 8);
            $table->float('percent_change_7d', 20, 8);
            $table->float('market_cap', 20, 8);
            $table->unsignedInteger('quote_id');
            $table->timestamps();


            $table->foreign('quote_id')->references('id')->on('quotes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
