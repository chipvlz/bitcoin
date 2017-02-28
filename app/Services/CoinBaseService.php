<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28/3/2016
 * Time: 10:18 PM
 */

namespace App\Services;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;

class CoinBaseService implements IBitExchangeService {

    protected $apiKey = "RkOUFS5y5FfnJ8Lj";
    protected $client;
    protected $apiSecret = "DSSGRJ1edPnNkhvBO2LLnl4PeNn6IMAr";

    public function __construct() {
        $this->client = Client::create(Configuration::apiKey($this->apiKey, $this->apiSecret));
    }

    public function send($adress, $amount, $comment) {
        try {

            $account = $this->client->getPrimaryAccount();
            $transaction = Transaction::send([
                        'toBitcoinAddress' => $adrress,
                        'amount' => new Money($amount, CurrencyCode::BTC),
                        'description' => $comment,
            ]);

            $this->client->createAccountTransaction($account, $transaction);
        } catch (Exception $ex) {
            
        }
    }

    public function receive($info) {
        //do stuff 
    }

    public function buyPrice() {
        $buyPrice = $this->client->getBuyPrice('BTC-USD');
        return $buyPrice->getAmount();
    }

    public function sellPrice() {
        $sellPrice = $this->client->getSellPrice('BTC-USD');
        return $sellPrice->getAmount();
    }

    public function getBalance() {

        $account = $client->getPrimaryAccount();
        $balance = $account->getBalance();
        return $balance->getAmount();
    }

    public function generateNewReceivedAddress() {

        $account = $this->client->getPrimaryAccount();
        $address = new Address([
            'name' => 'New Address'
        ]);
        $this->client->createAccountAddress($account, $address);
        return $address->getAddress();
    }

    public function getServerTime() {

        return $this->client->getTime();
    }

    public function currencyConvertUSDVND($amount, $fromCurrency, $toCurrency) {

        $url = "https://www.google.com/finance/converter?a=" . $amount . "&from=" . $fromCurrency . "&to=" . $toCurrency;
        $ch = curl_init();
        $timeout = 0;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $rawdata = curl_exec($ch);

        curl_close($ch);

        preg_match("/<span class=bld>(.*)<\/span>/", $rawdata, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted);

        return round($converted[0], 3);
    }

}
