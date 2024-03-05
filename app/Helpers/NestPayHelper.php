<?php

namespace App\Helpers;

class NestPayHelper
{
    public static function createHash($clientId, $orderId, $amount, $okUrl, $failUrl, $transactionType, $installment, $rnd, $storeKey)
    {
        $plaintext = $clientId . $orderId . $amount . $okUrl . $failUrl . $transactionType . $installment . $rnd . $storeKey;
        $hash = base64_encode(sha1($plaintext, true)); // SHA1 hash alınıp base64 kodlaması yapılıyor.
        return $hash;
    }
}