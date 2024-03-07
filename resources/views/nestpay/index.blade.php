<!DOCTYPE html>
<html>
<head>
    <title>Ödeme Formu</title>
    <meta http-equiv="Content-Language" content="tr">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="now">
</head>
<body>
    <form method="post" action="{{ route('process.payment') }}">
        @csrf
        <input type="hidden" name="clientid" value="100200127"/>
        <input type="hidden" name="storetype" value="3d_pay_hosting" />
        <input type="hidden" name="storekey" value="TEST1234" />
        <input type="hidden" name="islemtipi" value="Auth" />
        <input type="hidden" name="amount" value="91.96" />
        <input type="hidden" name="currency" value="949" />
        <input type="hidden" name="oid" value="1291899411421" />
        <input type="hidden" name="okUrl" value="http://buildingecommerce.test/payment/success"/>
        <input type="hidden" name="failUrl" value="http://buildingecommerce.test/payment/fail" />
        <input type="hidden" name="callbackurl" value="http://buildingecommerce.test/payment/callback" />
        <input type="hidden" name="lang" value="tr" />
        <input type="hidden" name="rnd" value="asdf" />
        <input type="hidden" name="pan" value="4546711234567894">
        <input type="hidden" name="Ecom_Payment_Card_ExpDate_Year" value="26" >
        <input type="hidden" name="Ecom_Payment_Card_ExpDate_Month" value="12">
        <!-- Hash hesaplama -->
        <?php
            $postData = [
                'clientid' => '100200127',
                'storetype' => '3d_pay_hosting',
                'storekey' => 'TEST1234',
                'islemtipi' => 'Auth',
                'amount' => '91.96',
                'currency' => '949',
                'oid' => '1291899411421',
                'okUrl' => 'http://buildingecommerce.test/payment/success',
                'failUrl' => 'http://buildingecommerce.test/payment/fail',
                'callbackurl' => 'http://buildingecommerce.test/payment/callback',
                'lang' => 'tr',
                'rnd' => 'asdf',
                'pan' => '4546711234567894',
                'Ecom_Payment_Card_ExpDate_Year' => '26',
                'Ecom_Payment_Card_ExpDate_Month' => '12',
            ];

            $hashval = "";
            foreach ($postData as $param => $value) {
                // Karakterlerin escape edilmesi
                $escapedValue = str_replace(['\\', '|'], ['\\\\', '\\|'], $value);
                $hashval .= $escapedValue . '|';
            }

            // StoreKey'in escape edilmesi
            $storeKey = 'TEST1234';
            $escapedStoreKey = str_replace(['\\', '|'], ['\\\\', '\\|'], $storeKey);
            $hashval .= $escapedStoreKey;

            // Hash hesaplanması
            $calculatedHashValue = hash('sha512', $hashval);
            $hash = base64_encode(pack('H*', $calculatedHashValue));
        ?>
        <input type="hidden" name="HASH" value="{{ $hash }}" />
        <!-- Hash hesaplama bitti -->
        <input type="submit" value="Ödemeyi Tamamla"/>
    </form>
</body>
</html>
