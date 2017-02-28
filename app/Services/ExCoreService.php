<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use DB;
use PDO;
use Illuminate\Support\Facades\Log;
use App\Services\BankType;
class ExCoreService implements IExCoreService {

    const bankUrl = "https://santienao.com/api/v1/bank_accounts/";

    public function excuteSpaMySQL($sProcedure, $aParams = null) {
        try {
            // create database connection
            $db = DB::connection()->getPdo();
            // if any params are present, add them
            $sParamsIn = '';
            if (isset($aParams) && is_array($aParams) && count($aParams) > 0) {
                // loop through params and set
                foreach ($aParams as $sParam) {
                    $sParamsIn .= '?,';
                }
                // trim the last comma from the params in string
                $sParamsIn = substr($sParamsIn, 0, strlen($sParamsIn) - 1);
            }

            // create initial stored procedure call
            $stmt = $db->prepare("CALL $sProcedure($sParamsIn)");

            // if any params are present, add them
            if (isset($aParams) && is_array($aParams) && count($aParams) > 0) {
                $iParamCount = 1;

                // loop through params and bind value to the prepare statement
                foreach ($aParams as &$value) {
                    $stmt->bindParam($iParamCount, $value);
                    $iParamCount++;
                }
            }

            // execute the stored procedure
            $stmt->execute();

            // loop through results and place into array if found
            $aData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // if the resultset has only 1 record, check the name of the stored procedure
            // if the name of the procedure has sel_rec within it, just return the one record
            if (count($aData) == 1 && strpos($sProcedure, 'sel_rec')) {
                $aData = $aData[0];
				
            }

            // return the data
            return $aData;
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return array();
        }
    }

    //fetcher bankinfo from external service
    public function fetchBankInfo($pBankNo,$bankType) {
        try {
            $ch = curl_init();
            // Set query data here with the URL

            curl_setopt($ch, CURLOPT_URL, self::bankUrl . $pBankNo);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, '3');

            // execute!
            $response = curl_exec($ch);

            // close the connection, release resources used
            curl_close($ch);
            $bankUserObject = json_decode($response);
            if (empty($bankUserObject->account_name) || $bankUserObject->account_name === "N/A") {
                return "";
            }
            //insert bank info
            $params=array();
            array_push($params,$bankUserObject->account_id,$bankType,$bankUserObject->account_name);
            $this->insertBankInfo($params);
            return $bankUserObject->account_name;
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return "";
        }
    }
    
    private function insertBankInfo($params){
        try{
            $this->excuteSpaMySQL("insertBankInfo",$params);
        }catch(Exception $ex){
            throw $ex;
        }        
    }

}
