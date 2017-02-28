<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('userinfo', function (Blueprint $table) {
            $table->increments('user_id')
            $table->float('balance');
            $table->bigInteger('total_bets')->nullable();
            $table->float('total_wagered')->nullable();
            $table->float('total_profit')->nullable();
            $table->string('sponsor_username')->nullable();
            $table->bigInteger('bet_win')->nullable();
            $table->bigInteger('bet_lose')->nullable();
            $table->float('total_deposit')->nullable();
            $table->float('total_withdraw')->nullable();
            $table->string('client_seed', '100')->nullable();
            $table->string('server_seed', '100')->nullable();
            $table->string('last_client_seed', '100')->nullable();
            $table->string('last_server_seed', '100')->nullable();
            $table->bigInteger('number_bet_seed')->nullable();
            $table->bigInteger('last_number_bet_seed')->nullable();
            $table->integer('total_ref')->nullable();
            $table->float('total_ref_wagered')->nullable();
            $table->float('total_commission')->nullable();
            $table->float('paid_commission')->nullable();
            $table->float('available_commission')->nullable();
            $table->boolean('is_dice')->nullable();
            $table->boolean('is_block')->nullable();
            $table->integer('total_ref');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
