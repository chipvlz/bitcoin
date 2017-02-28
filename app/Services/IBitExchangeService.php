<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28/3/2016
 * Time: 10:18 PM
 */

namespace App\Services;

interface IBitExchangeService {

    public function send($adress,$amount,$comment);

    public function receive($info);

    public function buyPrice();

    public function sellPrice();  

    public function getBalance();

    public function generateNewReceivedAddress();
	
	public function getServerTime();

    public function currencyConvertUSDVND($amount, $fromCurrency, $toCurrency);
}
