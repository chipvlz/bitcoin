<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IBitExchangeService;
use App\Services\IExCoreService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\BankType;
class ExchangeController extends Controller {

    const bankUrl = "https://santienao.com/api/v1/bank_accounts/"; 
	const remitanoUrl = "https://remitano.com/vn/offers/trade-bitcoin-in-vn-with-ease"; 
    public function index(Request $request) {

        return view('home');
    }

    public function sell(Request $request, IBitExchangeService $exchangeService, IExCoreService $exCoreService) {
        try {
            $params = $request->all();
            //create transation log into db
            //
            //generate address and QR Code
            $address = $exchangeService->generateNewReceivedAddress();
            $qr = QrCode::format('png')->size(300)->BTC($address, 3);
            $res = array('code' => 'MA0001', 'acc_no' => '09986632322', 'cash_amount' => '43534535', 'bit_amount' => '1.00000000'
                , 'qrcode' => base64_encode($qr), 'address' => $address);
            return response()->json(array('success' => 'true', 'data' => $res));
        } catch (Exception $ex) {
            return response()->json(array('success' => 'false', 'error' => "Loi he thong"));
        }
    }
    
    public function buy(Request $request, IBitExchangeService $exchangeService, IExCoreService $exCoreService){
        try{
            
        }catch(Exception $ex){
            return response()->json(array('success' => 'false', 'error' => "Loi he thong"));
        }
    }

    public function notify(Request $request, IBitExchangeService $exchangeService) {
        $url = "https://santienao.com/api/v1/bank_accounts/0041000241991";


        $ch = curl_init();
        // Set query data here with the URL
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        // do anything you want with your response
        var_dump($response);
        die("test");
    }

    public function getBanlance(Request $request, IBitExchangeService $exchangeService) {
        $address = $exchangeService->getBalance();
        die($address);
    }

    public function bankInfo(Request $request, IExCoreService $exCoreService) {
        $bankNo = $request->input("bank_no", "");

        if (!isset($bankNo) || $bankNo == "") {
            $errMgs = "Missing Bank ID";
            return response()->json(array('success' => 'false', 'errors' => $errMgs));
        }
        try {
            
            $params=array();                        
            array_push($params,$bankNo, BankType::VCB);
            //get bank info
            $bankUserInfo=$exCoreService->excuteSpaMySQL("getBankInfo", $params);            
            if(count($bankUserInfo)>0){				
                return response()->json(array('success' => 'true', 'account_name' => $bankUserInfo[0]["account_name"]));
            }
            //fetch bank info from external service
            $bankName=$exCoreService->fetchBankInfo($bankNo,BankType::VCB);
            if (empty($bankName)) {
                return response()->json(array('success' => 'false', 'error' => "Bank Account này không tồn tại"));
            }
            return response()->json(array('success' => 'true', 'account_name' => $bankName));
                        
        } catch (Exception $ex) {
            return response()->json(array('success' => 'false', 'error' => "Bank Account này không tồn tại"));
        }
    }

    public function getPrice(IBitExchangeService $exchangeService) {

        $usdRate = 23000;
        $my_ask_price = 0;
        $my_bid_price = 0;
        try {
            $usdRate = $exchangeService->currencyConvertUSDVND(1, "USD", "VND");
        } catch (Exception $ex) {
            $usdRate = 23000; 
        }


        try {
            $url = 'https://remitano.com/vn/offers/trade-bitcoin-in-vn-with-ease';
            //file_get_contents() reads remote webpage content
            $lines_string = file_get_contents($url);
            //output, you can also save it locally on the server

            $lastIndex = strripos(htmlspecialchars($lines_string), 'VND');
            $temp = subStr(htmlspecialchars($lines_string), $lastIndex - 90, 60);

            $bestBidPrice = subStr($temp, strrpos($temp, "btc_bid") + 14, 11);
            $bestAskPrice = subStr($temp, strrpos($temp, "btc_ask") + 14, 11);

            //echo('Gia mua remi ' + $bestBidPrice);
            //echo('-');
            //echo('Gia ban remi ' + $bestAskPrice);

            $bestRatio = floatval($bestAskPrice) - floatval($bestBidPrice);

            //echo('ratio' + $bestRatio);



            if ($bestRatio <= 120000) {
                $my_ask_price = floatval($bestAskPrice) + ((120000 - $bestRatio) / 2);
                $my_bid_price = floatval($bestBidPrice) - ((120000 - $bestRatio) / 2);
            } else {
                $my_ask_price = floatval($bestAskPrice) - (($bestRatio - 120000) / 2);
                $my_bid_price = floatval($bestBidPrice) + (($bestRatio - 120000) / 2);
            }

            //echo('Gia toi mua ' + $my_bid_price);
            //echo('--------------------');
            //echo('Gia toi ban ' + $my_ask_price);
        } catch (Exception $ex) {

            $my_ask_price = $exchangeService->sellPrice() * $usdRate;
            $my_bid_price = $exchangeService->buyPrice() * $usdRate;
        }
        //Push pirce to client
        $price = json_encode([
            'buy_price' => $my_ask_price,
            'sel_price' => $my_bid_price,
        ]);
        $response = new StreamedResponse(function()use($price) {
            echo 'data: ' . $price . "\n\n";
            ob_flush();
            flush();

            sleep(3);
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        return $response;
    }

}
