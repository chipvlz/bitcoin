<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Services;

interface IExCoreService {
    public function excuteSpaMySQL($sProcedure, $aParams = null);
    public function fetchBankInfo($pBankNo,$bankType);
}


