<?php

namespace App\Services;

use App\Helpers\NestPayHelper;

class NestPayService
{
    public function generateHash($clientId, $orderId, $amount, $okUrl, $failUrl, $transactionType, $installment, $rnd, $storeKey)
    {
        return NestPayHelper::createHash($clientId, $orderId, $amount, $okUrl, $failUrl, $transactionType, $installment, $rnd, $storeKey);
    }
}